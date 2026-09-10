<?php

use Livewire\Component;

new class extends Component
{
    public function dataset()
    {
        return $this->redirect('/dataset', navigate: true);
    }

    public function geoportal()
    {
        return $this->redirect('/geospasial', navigate: true);
    }

    public function docs()
    {
        return $this->redirect('/dokumentasi', navigate: true);
    }
};
?>

<section class="relative py-12 md:pt-16 md:pb-24 overflow-hidden bg-hero bg-cover bg-center">
    
    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="max-w-100 md:max-w-2xl h-125 md:h-125">
                <h1 class="max-w-75 text-2xl md:max-w-xl md:text-5xl lg:text-5xl font-bold text-slate-800 leading-tight">
                    SIMASSADAWAN
                </h1>
                <h1 class="max-w-50 text-2xl md:max-w-sm md:text-5xl lg:text-5xl font-bold text-brand-700 leading-tight mb-4">Sistem Manajemen Informasi Statistik Satu Data Way Kanan</h1>
                <p class="max-w-60 text-gray-500 md:max-w-md text-sm md:text-lg mb-8 leading-relaxed">
                    Mewujudkan keterbukaan data untuk mendukung pembangunan daerah yang transparan, partisipatif dan berkelanjutan.
                </p>

                
                {{-- <div class="flex bg-white rounded-full shadow-lg p-2 mt-60 md:mt-4 mb-8 max-w-xl md:max-w-lg border border-gray-100">
                    <input type="text" placeholder="Cari dataset, statistik, peta, publikasi..." class="grow px-4 py-2 bg-transparent outline-none text-slate-700 placeholder-slate-400">
                    <button class="bg-brand-700 hover:bg-brand-800 text-white w-12 h-12 rounded-full flex items-center justify-center transition shrink-0">
                        <i class="ph ph-magnifying-glass text-xl"></i>
                    </button>
                </div>

                
                <div class="hidden md:flex flex-wrap gap-3">
                    <button wire:click="dataset" class="bg-brand-700 hover:bg-brand-800 text-white px-5 py-2.5 rounded-full font-medium text-sm transition flex items-center gap-2 shadow-md">
                        <i class="ph ph-database text-lg"></i> Jelajahi Data
                    </button>
                    <button wire:click="geoportal" class="bg-white hover:bg-gray-50 text-brand-700 border border-brand-200 px-5 py-2.5 rounded-full font-medium text-sm transition flex items-center gap-2 shadow-sm">
                        <i class="ph ph-map-pin text-lg"></i> Lihat Peta
                    </button>
                    <button wire:click="docs" class="bg-white hover:bg-gray-50 text-brand-700 border border-brand-200 px-5 py-2.5 rounded-full font-medium text-sm transition flex items-center gap-2 shadow-sm">
                        <i class="ph ph-code text-lg"></i> Dokumentasi API
                    </button>
                </div> --}}
            </div>
            
        </div>
    </div>

    <div class="absolute inset-x-0 bottom-0 h-24 bg-linear-to-b from-transparent to-white pointer-events-none"></div>
</section>