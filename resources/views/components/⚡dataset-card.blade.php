<?php

use Livewire\Component;

use Illuminate\Support\Facades\Storage;

new class extends Component
{
    public $dataset;

    public function downloadFile()
    {
        return Storage::download($this->dataset->file);
    }
};
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-brand-700 transition group">
    <div class="flex flex-col md:flex-row md:items-start gap-4">
        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-1">
            <i class="{{ $dataset->typeData->icon }} text-xl"></i>
        </div>
        <div class="grow">
            <div class="flex justify-between items-start mb-1">
                <h2 class="text-lg font-bold text-slate-800 group-hover:text-brand-700 transition">
                    <a href="/dataset/{{ $dataset->slug }}" wire:navigate>{{ $dataset->name }}</a>
                </h2>
                <div class="hidden sm:flex gap-1 ml-4">
                    <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded-md font-medium border border-blue-100 flex items-center gap-1"><i class="ph ph-building"></i> {{ $dataset->uploadBy->categoryAccount->name }}</span>
                    <span style="background-color: color-mix(in srgb, {{ $dataset->typeData->color }} 10%, transparent);color: {{ $dataset->typeData->color }};border-color: {{ $dataset->typeData->color }};" class="text-[10px] px-2 py-1 rounded-md font-medium border flex items-center gap-1"><i class="{{ $dataset->typeData->icon }}"></i> {{ $dataset->typeData->name }}</span>
                    <span class="text-[10px] bg-purple-50 text-purple-600 px-2 py-1 rounded-md font-medium border border-purple-100 flex items-center gap-1"><i class="ph ph-code"></i> API</span>
                </div>
            </div>
            <div class="text-xs text-slate-500 mb-3 flex flex-wrap items-center gap-x-4 gap-y-1">
                <span class="flex items-center gap-1"><i class="ph ph-buildings text-slate-400"></i> {{ $dataset->uploadBy->name }}</span>
                <span class="flex items-center gap-1"><i class="ph ph-calendar text-slate-400"></i>{{ $dataset->created_at->translatedFormat('j F Y') }}</span>
                <span class="flex items-center gap-1"><i class="ph ph-clock text-slate-400"></i> Diperbarui {{ $dataset->updated_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-slate-600 line-clamp-2 mb-4 leading-relaxed">{{ $dataset->description }}</p>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-md">{{ $dataset->categoryData->name }}</span>
                    @if ($dataset->periodeData)
                    <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-md">{{ $dataset->periodeData->name }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-4 text-xs text-slate-500 font-medium cursor-pointer hover:text-brand-700" wire:click="downloadFile">
                    <span class="flex items-center gap-1"><i class="ph ph-download-simple text-lg"></i> Unduh</span>
                </div>
            </div>
            
            <div class="flex sm:hidden gap-1 mt-3 pt-3 border-t border-gray-100">
                <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100">{{ $dataset->uploadBy->categoryAccount->name }}</span>
                <span class="text-[10px] bg-purple-50 text-purple-600 px-2 py-1 rounded border border-purple-100">API</span>
            </div>

        </div>
    </div>
</div>