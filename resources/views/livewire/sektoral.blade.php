<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-8 shrink-0 relative overflow-hidden">
        
        <div class="absolute right-0 top-0 w-1/3 h-full bg-linear-to-l from-brand-50 to-transparent opacity-50 pointer-events-none"></div>
        
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <nav class="flex text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="/" wire:navigate class="hover:text-brand-700 transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1">Katalog Organisasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-2xl">
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 leading-tight mb-2">Produsen Data Sektoral</h1>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Jelajahi dataset yang dipublikasikan oleh berbagai instansi. Direktorat ini mencakup Satuan Kerja Perangkat Daerah (SKPD) Pemerintah Kabupaten Way Kanan serta instansi vertikal lainnya (Non-SKPD).
                    </p>
                </div>
                
                
                <div class="flex gap-4 shrink-0">
                    <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-2 text-center">
                        <div class="text-xl font-bold text-brand-700">{{ $this->totalSkpd }}</div>
                        <div class="text-[10px] uppercase font-semibold text-slate-500 tracking-wider">SKPD</div>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-2 text-center">
                        <div class="text-xl font-bold text-slate-700">{{ $this->totalNonSkpd }}</div>
                        <div class="text-[10px] uppercase font-semibold text-slate-500 tracking-wider">Non-SKPD</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 mb-8 flex flex-col md:flex-row gap-3">
            <div class="relative grow">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                <input type="text" wire:model.live="query" placeholder="Cari nama dinas, badan, atau instansi..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>
            
            <div class="flex gap-3">
                <div x-data="{open:false}" class="relative w-full sm:w-48">
                    <button @click="open=!open" class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2.5 sm:py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                        
                        <span>
                            {{ match($typeFilter) {
                                'all'     => 'Semua Tipe',
                                'skpd'     => 'SKPD',
                                'nonskpd' => 'Non-SKPD',
                            } }}
                        </span>

                        <i class="ph ph-caret-down text-slate-400"></i>
                    </button>

                    <div x-show="open" x-cloak x-transition.opacity @click.outside="open=false" class="absolute right-0 z-20 mt-2 w-full rounded-lg border border-gray-200 bg-white shadow-lg overflow-hidden">
                        <button x-on:click="open = false" wire:click="$set('typeFilter','all')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                            Semua Tipe
                        </button>

                        <button x-on:click="open = false" wire:click="$set('typeFilter','skpd')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                            SKPD
                        </button>

                        <button x-on:click="open = false" wire:click="$set('typeFilter','nonskpd')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                            Non-SKPD
                        </button>
                    </div>
                </div>
                <select class="bg-white border border-gray-200 text-slate-700 text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 block px-4 py-2.5 outline-none">
                    <option value="dataset_desc">Dataset Terbanyak</option>
                    <option value="name_asc">Abjad (A-Z)</option>
                    <option value="name_desc">Abjad (Z-A)</option>
                </select>
            </div>
        </div>

        
        <div class="mb-12">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                @foreach ($this->users as $user)                    
                <div class="rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-brand-300 transition group flex flex-col h-full bg-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 shrink-0 group-hover:scale-110 transition-transform">
                            <img src="{{ $user->photo ? url('storage/' . $user->photo) : url('storage/waykanan.webp') }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <span class="bg-slate-50 text-slate-700 border border-slate-200 text-[10px] font-bold px-2 py-1 rounded-md">{{ $user->categoryAccount->name }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-brand-700 transition leading-snug">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4 grow">{{ $user->address }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-medium uppercase">Total Dataset</span>
                            <span class="text-sm font-bold text-slate-800">{{ $user->datasets->count() }}</span>
                        </div>
                        <a href="/dataset" wire:navigate class="bg-slate-700 text-white text-xs font-semibold flex items-center gap-1 hover:bg-slate-800 transition px-3 py-1.5 rounded-lg shadow-sm">
                            Lihat Data <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
            
            @if ($this->users->isNotEmpty() && $this->users->count() < $this->total)                
            <div class="mt-6 text-center">
                <button wire:click="loadMore" class="bg-white border border-gray-300 text-slate-600 hover:bg-gray-50 hover:text-brand-700 px-6 py-2.5 rounded-lg font-medium text-sm transition shadow-sm">
                    Muat Lebih Banyak SKPD ({{ $this->total - $this->limit }} Lagi)
                </button>
            </div>
            @endif

        </div>

    </main>
</div>
