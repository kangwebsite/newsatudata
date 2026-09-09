<?php

namespace App\Livewire;

use App\Models\CategoryAccount;
use App\Models\CategoryData;
use App\Models\Dataset as ModelsDataset;
use App\Models\TypeData;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Dataset extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    public $dataTypes, $years;

    public $query = '';
    public $queryOpd = '';
    public $sort = 'latest';
    
    #[Session(key: 'activeFilters')]
    public $activeFilters = [
        'topik' => [],
        'organisasi' => [],
        'typedata' => [],
        'sektoral' => [],
        'tahun' => [],
    ];

    public function mount()
    {
        $this->dataTypes = TypeData::get('*');
        $this->years = ModelsDataset::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');
    }

    public function removeFilter($group, $id)
    {
        if (isset($this->activeFilters[$group][$id])) {
            $this->activeFilters[$group][$id] = false;
        }
    }

    public function clearAllFilters()
    {
        $this->activeFilters = [
            'topik' => [],
            'organisasi' => [],
            'typedata' => [],
            'sektoral' => [],
            'tahun' => [],
        ];
    }

    public function paginationView()
    {
        return 'custom-pagination';
    }

    #[Computed]
    public function activeFilterBadges()
    {
        $badges = collect();

        $topikIds = array_keys(array_filter($this->activeFilters['topik'] ?? []));
        if (!empty($topikIds) && $this->categories) {
            foreach (collect($this->categories)->whereIn('id', $topikIds) as $item) {
                $badges->push(['type' => 'topik', 'id' => $item->id, 'label' => $item->name]);
            }
        }

        $orgIds = array_keys(array_filter($this->activeFilters['organisasi'] ?? []));
        if (!empty($orgIds) && $this->organisations) {
            foreach (collect($this->organisations)->whereIn('id', $orgIds) as $item) {
                $badges->push(['type' => 'organisasi', 'id' => $item->id, 'label' => $item->name]);
            }
        }

        $typeIds = array_keys(array_filter($this->activeFilters['typedata'] ?? []));
        if (!empty($typeIds) && $this->dataTypes) {
            foreach (collect($this->dataTypes)->whereIn('id', $typeIds) as $item) {
                $badges->push(['type' => 'typedata', 'id' => $item->id, 'label' => $item->name]);
            }
        }

        $sekIds = array_keys(array_filter($this->activeFilters['sektoral'] ?? []));
        if (!empty($sekIds) && $this->categoryAccounts) {
            foreach (collect($this->categoryAccounts)->whereIn('id', $sekIds) as $item) {
                $badges->push(['type' => 'sektoral', 'id' => $item->id, 'label' => $item->name]);
            }
        }

        $yearIds = array_keys(array_filter($this->activeFilters['tahun'] ?? []));
        if (!empty($yearIds)) {
            foreach ($yearIds as $year) {
                $badges->push(['type' => 'tahun', 'id' => $year, 'label' => $year]);
            }
        }

        return $badges;
    }

    #[Computed]
    public function datasets()
    {
        $topikIds = array_keys(array_filter($this->activeFilters['topik']));
        $orgIds = array_keys(array_filter($this->activeFilters['organisasi']));
        $sekIds = array_keys(array_filter($this->activeFilters['sektoral']));
        $typeIds = array_keys(array_filter($this->activeFilters['typedata']));
        $yearIds = array_keys(array_filter($this->activeFilters['tahun']));

        return ModelsDataset::with(['uploadBy.categoryAccount', 'categoryData', 'periodeData', 'typeData'])
            ->where('status', 'approved')
            ->when($this->query, function ($q) {
                $q->where('name', 'like', "%{$this->query}%")->orWhere('description', 'like', "%{$this->query}%");
            })
            ->when(!empty($topikIds), function ($q) use ($topikIds) {
                $q->whereIn('category_data_id', $topikIds);
            })
            ->when(!empty($orgIds), function ($q) use ($orgIds) {
                $q->whereIn('upload_by', $orgIds);
            })
            ->when(!empty($typeIds), function ($q) use ($typeIds) {
                $q->whereIn('type_data_id', $typeIds);
            })
            ->when(!empty($sekIds), function ($q) use ($sekIds) {
                $q->whereHas('uploadBy', function ($userQuery) use ($sekIds) {
                    $userQuery->whereIn('category_account_id', $sekIds);
                });
            })
            ->when(!empty($yearIds), function ($q) use ($yearIds) {
                $q->where(function ($query) use ($yearIds) {
                    foreach ($yearIds as $year) {
                        $query->orWhereYear('created_at', $year);
                    }
                });
            })
            ->when($this->sort === 'latest', function ($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->when($this->sort === 'oldest', function ($q) {
                $q->orderBy('created_at', 'asc');
            })
            ->when($this->sort === 'az', function ($q) {
                $q->orderBy('name', 'asc');
            })
            ->paginate(7)->onEachSide(1);
    }


    #[Computed]
    public function categories()
    {
        return CategoryData::withCount('datasets')->get();
    }

    #[Computed]
    public function organisations()
    {
        return User::withCount('datasets')->where('role', 'user')->when($this->queryOpd, fn ($query) => $query->where('name', 'like', "%{$this->queryOpd}%"))->get();
    }

    #[Computed]
    public function categoryAccounts()
    {
        return CategoryAccount::all();
    }

    public function render()
    {
        return view('livewire.dataset')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Katalog Dataset',
                description: 'Temukan, eksplorasi, dan unduh data terbuka Kabupaten Way Kanan.'
            )
        ]);
    }
}
