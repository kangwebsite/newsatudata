<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center gap-5">

            <a href="/" wire:navigate>
                <div class="flex items-center gap-3">
                    <div class="h-13 flex items-center justify-center">
                        <img src="{{ url('storage/waykanan.webp') }}" alt="Logo Way Kanan" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-lg leading-tight text-brand-700">Satu Data</span>
                        <span class="font-bold text-lg leading-tight text-brand-700">Way Kanan</span>
                    </div>
                </div>
            </a>
            

            <div class="hidden md:flex space-x-4 items-center h-full ml-auto">    
                <a href="/" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('/') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Beranda</a>
                <a href="/sektoral" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('sektoral*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Sektoral</a>
                <a href="/geospasial" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('geospasial*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Geospasial</a>
                <a href="/publikasi" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('publikasi*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Publikasi</a>
                <a href="/dataset" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('dataset*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Dataset</a>
                <a href="/metadata" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('metadata*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Metadata</a>
                <a href="/visualisasi" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('visualisasi*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Visualisasi</a>
                <a href="/dokumentasi" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('dokumentasi*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Dokumentasi API</a>
                <a href="/pengaduan" class="font-semibold text-sm border-b-2 py-4 flex transition items-center px-1 hover:text-brand-700 hover:border-brand-700 {{ request()->is('pengaduan*') ? 'text-brand-700 border-brand-700' : 'text-slate-600 border-transparent' }}" wire:navigate>Pengaduan</a>
            </div>

            
            <div class="flex items-center border-l-2 border-gray-100 pl-4">
                @auth
                <a href="/admin" class="hover:bg-brand-700 hover:text-white text-brand-700 border-2 px-5 py-2.5 rounded-full font-medium text-sm transition flex items-center gap-2 shadow-md shadow-brand-700/20">
                    Dashboard
                </a>
                @else
                <a href="/admin/login" class="bg-brand-700 hover:bg-transparent hover:text-brand-700 border-2 text-white px-5 py-2.5 rounded-full font-medium text-sm transition flex items-center gap-2 shadow-md shadow-brand-700/20">
                    Masuk
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
