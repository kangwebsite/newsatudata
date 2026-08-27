<?php

use Livewire\Component;

use App\Models\Dataset;

new class extends Component {
    public $datasets;

    public function mount()
    {
        $this->datasets = Dataset::with(['categoryData', 'typeData', 'periodeData'])->latest()->limit(5)->get();
    }
};
?>

<div class="bg-white rounded-2xl p-6 shadow-gray-200 shadow-lg border border-slate-100 font-sans">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-slate-800 text-lg">Dataset Terbaru</h3>
        <a href="/dataset" wire:navigate class="text-xs text-slate-500 hover:text-brand-600 flex items-center gap-1">Lihat Semua <i class="ph ph-arrow-right"></i></a>
    </div>
    <div class="flex flex-col gap-3 justify-between">
        
        @foreach ($this->datasets as $dataset)            
        <div class="border px-3 py-2 rounded-lg border-gray-200">
            <a href="/dataset/{{ $dataset->slug }}" wire:navigate class="text-sm font-semibold text-slate-800 hover:text-brand-600 line-clamp-2 mb-2">{{ $dataset->name }}</a>
            <div class="flex justify-between items-center">
                <div class="flex gap-1">
                    <span class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100">{{ $dataset->categoryData->name }}</span>
                    <span class="text-[10px] bg-green-50 text-green-600 px-1.5 py-0.5 rounded border border-green-100">{{ $dataset->typeData->name }}</span>
                    <span class="text-[10px] bg-purple-50 text-purple-600 px-1.5 py-0.5 rounded border border-purple-100">{{ $dataset->periodeData->name ?? '-' }}</span>
                </div>
                <span class="text-[10px] text-slate-400">{{ $dataset->updated_at->diffForHumans() }}</span>
            </div>
        </div>
        @endforeach
        
    </div>
</div>
