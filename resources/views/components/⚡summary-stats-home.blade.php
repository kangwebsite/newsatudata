<?php

use Livewire\Component;

use App\Models\Dataset;
use App\Models\User;
use App\Models\Geoportal;
use App\Models\Post;
use App\Models\Metadata;
use Livewire\Attributes\Computed;

new class extends Component
{

    #[Computed]
    public function datasetCount()
    {
        return Dataset::all()->count();
    }

    #[Computed]
    public function organisationCount()
    {
        return User::where('role', 'user')->get()->count();
    }

    #[Computed]
    public function geoCount()
    {
        return Geoportal::all()->count();
    }

    #[Computed]
    public function newsCount()
    {
        return Post::all()->count();
    }

    #[Computed]
    public function metadataCount()
    {
        return Metadata::all()->count();
    }
};
?>

<div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 md:-mt-12 relative z-20">
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        
        <div class="bg-white rounded-2xl shadow-soft p-4 shrink-0 flex flex-col justify-between border border-gray-50 snap-start">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-brand-500">
                    <i class="ph ph-database text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider">Dataset</div>
                    <div class="text-xl font-bold text-slate-800">{{ $this->datasetCount }}</div>
                </div>
            </div>
            <a href="/dataset" wire:navigate class="text-brand-500 text-xs font-semibold flex items-center gap-1 hover:text-brand-700 mt-0 md:mt-2">Lihat Detail <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft p-4 shrink-0 flex flex-col justify-between border border-gray-50 snap-start">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                    <i class="ph ph-buildings text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider">OPD</div>
                    <div class="text-xl font-bold text-slate-800">{{ $this->organisationCount }}</div>
                </div>
            </div>
            <a href="/sektoral" wire:navigate class="text-brand-500 text-xs font-semibold flex items-center gap-1 hover:text-brand-700 mt-0 md:mt-2">Lihat Detail <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft p-4 shrink-0 flex flex-col justify-between border border-gray-50 snap-start">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <i class="ph ph-map-pin text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider">Geospasial</div>
                    <div class="text-xl font-bold text-slate-800">{{ $this->geoCount }}</div>
                </div>
            </div>
            <a href="/geospasial" wire:navigate class="text-brand-500 text-xs font-semibold flex items-center gap-1 hover:text-brand-700 mt-0 md:mt-2">Lihat Detail <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft p-4 shrink-0 flex flex-col justify-between border border-gray-50 snap-start">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <i class="ph ph-book-open-text text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider">Metadata</div>
                    <div class="text-xl font-bold text-slate-800">{{ $this->metadataCount }}</div>
                </div>
            </div>
            <a href="/metadata" wire:navigate class="text-brand-500 text-xs font-semibold flex items-center gap-1 hover:text-brand-700 mt-0 md:mt-2">Lihat Detail <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft p-4 shrink-0 flex flex-col justify-between border border-gray-50 snap-start">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                    <i class="ph ph-newspaper text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider">Publikasi</div>
                    <div class="text-xl font-bold text-slate-800">{{ $this->newsCount }}</div>
                </div>
            </div>
            <a href="/publikasi" wire:navigate class="text-brand-500 text-xs font-semibold flex items-center gap-1 hover:text-brand-700 mt-0 md:mt-2">Lihat Detail <i class="ph ph-arrow-right"></i></a>
        </div>

    </div>
</div>