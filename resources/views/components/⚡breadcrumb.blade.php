<?php

use Livewire\Component;

new class extends Component
{
    public string $title = '';
};
?>

<div class="bg-white border-b border-gray-200 pt-6 pb-4">
    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-slate-500 mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="index.html" class="hover:text-brand-700 transition flex items-center gap-1">
                        <i class="ph ph-house"></i> Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                        <span class="text-slate-700 font-medium ml-1">{{ $title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $title }}</h1>
                <p class="text-sm text-slate-600 mt-1">Temukan, eksplorasi, dan unduh data terbuka Kabupaten Way Kanan.</p>
            </div>
            <div class="text-sm text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                Menampilkan <span class="font-semibold text-slate-800">1.452</span> dataset
            </div>
        </div>
    </div>
</div>