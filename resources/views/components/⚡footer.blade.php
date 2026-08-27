<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<footer class="bg-brand-900 text-white pt-8 pb-6">
    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-8">


            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <livewire:brand-logo />
                    <div class="flex flex-col">
                        <span class="font-bold text-md leading-tight text-white">Satu Data Way Kanan</span>
                    </div>
                </div>
                <p class="text-xs text-brand-100 leading-relaxed opacity-80">
                    Portal Data Resmi Kabupaten Way Kanan merupakan platform penyediaan dan publikasi data daerah yang bertujuan mewujudkan keterbukaan informasi serta meningkatkan akses masyarakat terhadap data yang akurat, terpercaya, dan dapat dipertanggungjawabkan. Portal ini menyediakan berbagai informasi dan dataset sektoral yang dapat dimanfaatkan oleh masyarakat, pemerintah, akademisi, pelaku usaha, maupun pemangku kepentingan lainnya sebagai sumber informasi dalam mendukung perencanaan, pelaksanaan, dan evaluasi pembangunan daerah.
                </p>
            </div>


            <div>
                <h4 class="font-semibold text-sm mb-4">Portal</h4>
                <ul class="space-y-2 text-xs text-brand-100 opacity-80">
                    <li><a href="/" wire:navigate class="hover:text-white transition">Beranda</a></li>
                    <li><a href="/dataset" wire:navigate class="hover:text-white transition">Dataset</a></li>
                    <li><a href="/geospasial" wire:navigate class="hover:text-white transition">Geospasial</a></li>
                    <li><a href="/visualisasi" wire:navigate class="hover:text-white transition">Visualisasi</a></li>
                    <li><a href="/publikasi" wire:navigate class="hover:text-white transition">Publikasi</a></li>                    
                </ul>
            </div>


            <div>
                <h4 class="font-semibold text-sm mb-4">Informasi</h4>
                <ul class="space-y-2 text-xs text-brand-100 opacity-80">
                    <li><a href="/tentang" wire:navigate class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="/kebijakan" wire:navigate class="hover:text-white transition">Kebijakan Data</a></li>
                    <li><a href="/metadata" wire:navigate class="hover:text-white transition">Metadata</a></li>
                    <li><a href="/sektoral" wire:navigate class="hover:text-white transition">Produsen Data</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-sm mb-4">Layanan</h4>
                <ul class="space-y-2 text-xs text-brand-100 opacity-80">
                    <li><a href="/dokumentasi" wire:navigate class="hover:text-white transition">Dokumentasi API</a></li>
                    <li><a href="/pengaduan" wire:navigate class="hover:text-white transition">Pengaduan</a></li>
                </ul>
            </div>
            
            
            <div class="lg:col-span-1">
                <h4 class="font-semibold text-sm mb-4">Kontak Kami</h4>
                <ul class="space-y-3 text-xs text-brand-100 opacity-80 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="ph ph-map-pin mt-0.5"></i>
                        <span>Jl. Way Kanan Raya Perkantoran<br>Blambangan Umpu, Way Kanan<br>Lampung 34764</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ph ph-phone"></i> (0723) 461 001
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ph ph-envelope-simple"></i> diskominfo@waykanankab.go.id
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-brand-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-xs text-brand-200 opacity-60">
                &copy; {{ date('Y') }} Pemerintah Kabupaten Way Kanan. All Rights Reserved.
            </div>
            <div class="flex items-center gap-4 text-xs text-brand-200 opacity-60">
                <a href="#" class="hover:text-white transition">Sitemap</a>
                <span class="w-1 h-1 bg-brand-500 rounded-full"></span>
                <a href="#" class="hover:text-white transition">Privasi</a>
                <span class="w-1 h-1 bg-brand-500 rounded-full"></span>
                <a href="#" class="hover:text-white transition">Kebijakan Penggunaan</a>
                <span class="w-1 h-1 bg-brand-500 rounded-full"></span>
                <a href="#" class="hover:text-white transition">Aksesibilitas</a>
            </div>
        </div>
    </div>
</footer>
