<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Indikator Daerah</h2>
        <div class="flex gap-3">
            <select class="bg-white border border-gray-200 text-slate-700 text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 block p-2 outline-none">
                <option>Tahunan</option>
                <option>Bulanan</option>
            </select>
            <select class="bg-white border border-gray-200 text-slate-700 text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 block p-2 outline-none">
                <option>2025</option>
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        
        <!-- Indicator 1 -->
        <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">Pendapatan Daerah</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">Rp 2,35 Triliun</div>
                <div class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">+12.4%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Green) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,30 L0,20 Q10,25 20,15 T40,20 T60,10 T80,5 L100,0 L100,30 Z" fill="rgba(34, 197, 94, 0.1)" />
                    <path d="M0,20 Q10,25 20,15 T40,20 T60,10 T80,5 L100,0" fill="none" stroke="#22c55e" stroke-width="2" />
                </svg>
            </div>
        </div>

        <!-- Indicator 2 -->
        <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">IPM</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">72,45</div>
                <div class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">+1.25%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Blue) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,30 L0,25 Q15,20 25,10 T50,15 T75,5 L100,2 L100,30 Z" fill="rgba(59, 130, 246, 0.1)" />
                    <path d="M0,25 Q15,20 25,10 T50,15 T75,5 L100,2" fill="none" stroke="#3b82f6" stroke-width="2" />
                </svg>
            </div>
        </div>

            <!-- Indicator 3 -->
            <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">Kemiskinan</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">9,12%</div>
                <div class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">-0.85%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Orange/Downward is good here, let's use orange for variety or green if downward is positive indicator. Image shows orange.) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,30 L0,5 Q15,10 30,20 T60,15 T80,25 L100,28 L100,30 Z" fill="rgba(249, 115, 22, 0.1)" />
                    <path d="M0,5 Q15,10 30,20 T60,15 T80,25 L100,28" fill="none" stroke="#f97316" stroke-width="2" />
                </svg>
            </div>
        </div>

        <!-- Indicator 4 -->
        <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">PDRB</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">18,45 Triliun</div>
                <div class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">+5.32%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Teal) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                        <path d="M0,30 L0,22 Q10,25 25,18 T50,15 T75,5 L100,8 L100,30 Z" fill="rgba(20, 184, 166, 0.1)" />
                    <path d="M0,22 Q10,25 25,18 T50,15 T75,5 L100,8" fill="none" stroke="#14b8a6" stroke-width="2" />
                </svg>
            </div>
        </div>

            <!-- Indicator 5 -->
            <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">Inflasi</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">2,45%</div>
                <div class="text-xs font-semibold text-red-500 bg-red-50 px-1.5 py-0.5 rounded">+0.35%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Purple) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,30 L0,15 Q15,5 30,15 T60,20 T80,10 L100,5 L100,30 Z" fill="rgba(168, 85, 247, 0.1)" />
                    <path d="M0,15 Q15,5 30,15 T60,20 T80,10 L100,5" fill="none" stroke="#a855f7" stroke-width="2" />
                </svg>
            </div>
        </div>

        <!-- Indicator 6 -->
        <div class="bg-white rounded-xl shadow-card p-4 border border-gray-100 relative overflow-hidden">
            <div class="text-xs text-slate-500 font-medium mb-1">Pengangguran</div>
            <div class="flex items-end justify-between mb-2">
                <div class="text-lg font-bold text-slate-800">3,65%</div>
                <div class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">-0.42%</div>
            </div>
            <div class="text-[10px] text-slate-400 mb-4">dibanding tahun lalu</div>
            <!-- Sparkline SVG (Light Green) -->
            <div class="absolute bottom-0 left-0 w-full h-12 opacity-80">
                <svg viewBox="0 0 100 30" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,30 L0,10 Q20,15 40,25 T70,20 L100,28 L100,30 Z" fill="rgba(132, 204, 22, 0.1)" />
                    <path d="M0,10 Q20,15 40,25 T70,20 L100,28" fill="none" stroke="#84cc16" stroke-width="2" />
                </svg>
            </div>
        </div>

    </div>
</section>