<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Sektoral extends Component
{
    public $limit = 8;
    public $total = 0;

    public $query = '';

    public $totalSkpd, $totalNonSkpd;

    public $typeFilter = 'all';

    public function mount()
    {
        $this->total = User::where('role', 'user')->count();

        $this->totalSkpd = User::where('role', 'user')->whereHas('categoryAccount', fn($q) => $q->where('slug', 'skpd'))->count();
        $this->totalNonSkpd = User::where('role', 'user')->whereHas('categoryAccount', fn($q) => $q->where('slug', 'non-skpd'))->count();
    }

    #[Computed]
    public function users()
    {
        return User::with(['categoryAccount', 'datasets'])
            ->where('role', 'user')
            ->when($this->query, function ($q) {
                $q->where('name', 'like', "%{$this->query}%")->orWhere('address', 'like', "%{$this->query}%");
            })
            ->when($this->typeFilter === 'skpd', function ($q) {
                $q->whereHas('categoryAccount', fn($q) => $q->where('slug', 'skpd'));
            })
            ->when($this->typeFilter === 'nonskpd', function ($q) {
                $q->whereHas('categoryAccount', fn($q) => $q->where('slug', 'non-skpd'));
            })
            ->orderBy('name')
            ->take($this->limit)
            ->get();
    }

    public function loadMore()
    {
        $this->limit += 8;
    }

    public function render()
    {
        return view('livewire.sektoral')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Sektoral',
                description: 'Jelajahi dataset yang dipublikasikan oleh berbagai instansi. Direktorat ini mencakup Satuan Kerja Perangkat Daerah (SKPD) Pemerintah Kabupaten Way Kanan serta instansi vertikal lainnya (Non-SKPD).'
            )
        ]);
    }
}
