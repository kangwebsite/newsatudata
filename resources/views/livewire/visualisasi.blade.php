<div>
    <div class="bg-white border-b border-gray-200 pt-8 pb-10 shrink-0 relative overflow-hidden">
        
        <div class="absolute right-0 top-0 w-1/2 h-full bg-linear-to-l from-brand-50 to-transparent pointer-events-none"></div>
        
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <nav class="flex text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="index.html" class="hover:text-brand-700 transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1">Visualisasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-800 leading-tight mb-3">
                        Visualisasi
                    </h1>
                    <p class="text-base text-slate-600 leading-relaxed">
                        Eksplorasi kumpulan grafik dan ringkasan visual statistik daerah Kabupaten Way Kanan untuk memudahkan pemahaman tren dan pola data.
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <main class="grow w-full py-10 bg-gray-50">
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                @foreach ($this->chartData as $chart)

                @livewire(\App\Livewire\VisualBar::class, ['chart' => $chart])
                    
                @endforeach

            </div>

        </div>
    </main>
</div>
