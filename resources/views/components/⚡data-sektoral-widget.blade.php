<?php

use Livewire\Component;
use App\Models\CategoryData;
use Livewire\Attributes\Computed;

new class extends Component {
    
    #[Computed]
    public function categories()
    {
        return CategoryData::withCount('datasets')->limit(6)->get();
    }

    public function goToDataset($categoryId)
    {
        $category = CategoryData::findOrFail($categoryId);
        
        $filters = session()->get('activeFilters', [
            'topik' => [],
            'organisasi' => [],
            'typedata' => [],
            'sektoral' => [],
            'tahun' => [],
        ]);

        $filters['topik'] = [$categoryId => true];

        session()->put('activeFilters', $filters);
        
        return $this->redirect('/dataset', navigate: true);
    }
};
?>

<section class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Topik Data</h2>
        <a href="/dataset" wire:navigate class="text-brand-600 text-sm font-semibold flex items-center gap-1 hover:text-brand-800">Lihat
            Semua Topik <i class="ph ph-arrow-right"></i></a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">

        @foreach ($this->categories as $category)            
        <div wire:click="goToDataset({{ $category->id }})" class="bg-white rounded-xl shadow-card p-4 border border-gray-100 hover:shadow-md transition cursor-pointer flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <i class="{{ $category->icon }} text-xl" style="color: {{ $category->color }}"></i>
                    <h3 class="font-semibold text-slate-800 text-sm">{{ $category->name }}</h3>
                </div>
                <div class="text-2xl font-bold text-slate-800 mb-1">{{ $category->datasets_count }}</div>
                <div class="text-xs text-slate-500">Dataset</div>
            </div>
        </div>
        @endforeach

    </div>
</section>
