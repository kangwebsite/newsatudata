<div>
    {{-- Breadcrumb --}}
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
                            <span class="text-slate-700 font-medium ml-1">Katalog Dataset</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Katalog Dataset</h1>
                    <p class="text-sm text-slate-600 mt-1">Temukan, eksplorasi, dan unduh data terbuka Kabupaten Way Kanan.</p>
                </div>
                <div class="text-sm text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                    Total Keseluruhan <span class="font-semibold text-slate-800">{{ number_format($this->datasets()->total(), 0, '.', '.') }}</span> dataset
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-4" x-data="{ showMobileFilter: false }">
            
            <button @click="showMobileFilter = !showMobileFilter" class="lg:hidden w-full bg-white border border-gray-200 text-slate-700 py-2 rounded-lg font-medium flex justify-center items-center gap-2 shadow-sm">
                <i class="ph" :class="showMobileFilter ? 'ph-x' : 'ph-faders'"></i> 
                <span x-text="showMobileFilter ? 'Sembunyikan Filter' : 'Tampilkan Filter'"></span>
            </button>

            
            <aside :class="showMobileFilter ? 'block' : 'hidden'" class="lg:block w-full lg:w-75 shrink-0 space-y-6">
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">

                    <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="ph ph-tag text-brand-600"></i> Topik
                    </h3>
                    
                    <div class="space-y-3 max-h-100 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($this->categories as $category)                            
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="form-checkbox" wire:model.live="activeFilters.topik.{{ $category->id }}">
                                <span class="text-sm text-slate-600 group-hover:text-brand-700 transition">{{ $category->name }}</span>
                            </div>
                            <span class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $category->datasets_count }}</span>
                        </label>
                        @endforeach
                    </div>
                    <hr>

                    <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="ph ph-calendar text-brand-600"></i> Tahun
                    </h3>
                    
                    <div class="space-y-3 max-h-100 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($this->years as $year)                            
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="form-checkbox" wire:model.live="activeFilters.tahun.{{ $year }}">
                                <span class="text-sm text-slate-600 group-hover:text-brand-700 transition">{{ $year }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <hr>

                    <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="ph ph-building text-brand-600"></i> Sektoral
                    </h3>
                    
                    <div class="space-y-3 max-h-100 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($this->categoryAccounts as $categoryAccount)                            
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="form-checkbox" wire:model.live="activeFilters.sektoral.{{ $categoryAccount->id }}">
                                <span class="text-sm text-slate-600 group-hover:text-brand-700 transition">{{ $categoryAccount->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <hr>

                    <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="ph ph-buildings text-brand-600"></i> Organisasi (OPD)
                    </h3>
                    
                    <div class="relative mb-3">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" placeholder="Cari dinas/badan..." wire:model.live="queryOpd" class="w-full text-xs pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded outline-none focus:border-brand-500 focus:bg-white transition">
                    </div>
                    <div class="space-y-3 max-h-100 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($this->organisations as $organisation)                            
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="form-checkbox" wire:model.live="activeFilters.organisasi.{{ $organisation->id }}">
                            <span class="text-sm text-slate-600 group-hover:text-brand-700 transition line-clamp-1">{{ $organisation->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    <hr>

                    <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="ph ph-file-code text-brand-600"></i> Tipe Data
                    </h3>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach ($this->dataTypes as $typeData)                            
                        <label class="cursor-pointer">
                            <input type="checkbox" class="peer hidden" value="{{ $typeData->id }}" wire:model.live="activeFilters.typedata.{{ $typeData->id }}">
                            <span class="inline-block px-3 py-1.5 text-xs font-medium bg-white border border-slate-200 rounded-lg text-slate-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 peer-checked:border-brand-500 transition hover:bg-slate-50">{{ $typeData->name }}</span>
                        </label>
                        @endforeach
                    </div>

                </div>
                
            </aside>

            
            <main class="grow">
                <div class="flex flex-col gap-4">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-0">
    
                        <div class="grow flex items-center gap-3 px-1 w-full">
                            <i class="ph ph-magnifying-glass text-xl text-slate-400"></i>
                            <input type="search" placeholder="Cari nama dataset, deskripsi, atau kata kunci..." wire:model.live="query" class="w-full bg-transparent outline-none text-slate-700 text-sm py-1.5">
                        </div>

                        <div class="w-full sm:w-auto border-t sm:border-t-0 sm:border-l border-gray-200 pt-3 sm:pt-0 sm:pl-3">
                            
                            <div x-data="{open:false}" class="relative w-full sm:w-48">
                                <button @click="open=!open" class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2.5 sm:py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                    
                                    <span>
                                        {{ match($sort) {
                                            'latest' => 'Urutkan : Terbaru',
                                            'oldest' => 'Urutkan : Terlama',
                                            'az' => 'Urutkan : A - Z',
                                        } }}
                                    </span>

                                    <i class="ph ph-caret-down text-slate-400"></i>
                                </button>

                                <div x-show="open" x-cloak x-transition.opacity @click.outside="open=false" class="absolute right-0 z-20 mt-2 w-full rounded-lg border border-gray-200 bg-white shadow-lg overflow-hidden">
                                    <button x-on:click="open = false" wire:click="$set('sort','latest')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                                        Urutkan : Terbaru
                                    </button>

                                    <button x-on:click="open = false" wire:click="$set('sort','oldest')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                                        Urutkan : Terlama
                                    </button>

                                    <button x-on:click="open = false" wire:click="$set('sort','az')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                                        Urutkan : A - Z
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    @if($this->activeFilterBadges->isNotEmpty())
                        <div class="flex items-center flex-wrap gap-2 bg-white py-2 p-4 shadow-sm border border-gray-200 rounded-xl">
                            <span class="text-sm font-medium text-slate-500 mr-2">Filter Aktif:</span>
                            
                            @foreach($this->activeFilterBadges->take(2) as $badge)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200 capitalize">
                                    {{ $badge['type'] }}: {{ $badge['label'] }}
                                    <button type="button" wire:click="removeFilter('{{ $badge['type'] }}', {{ $badge['id'] }})" class="hover:bg-brand-200 hover:text-brand-900 p-0.5 rounded transition-colors focus:outline-none cursor-pointer" title="Hapus filter">
                                        <i class="ph ph-x"></i>
                                    </button>
                                </span>
                            @endforeach

                            @if($this->activeFilterBadges->count() > 2)
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200 capitalize cursor-pointer hover:bg-gray-100 transition">
                                        <span class="p-0.5">
                                            <i class="ph" :class="open ? 'ph-minus' : 'ph-plus'"></i>
                                        </span>
                                        {{ $this->activeFilterBadges->count() - 2 }} Filter Lainnya
                                    </button>

                                    <div x-show="open" x-cloak x-transition.opacity @click.outside="open = false" class="absolute left-0 sm:left-auto sm:right-0 z-20 mt-2 w-64 rounded-xl border border-gray-200 bg-white shadow-lg p-2 space-y-1.5">
                                        @foreach($this->activeFilterBadges->skip(2) as $badge)
                                            <div class="flex items-center justify-between px-3 py-2 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200 capitalize">
                                                <span class="line-clamp-1">{{ $badge['type'] }}: {{ $badge['label'] }}</span>
                                                <button type="button" wire:click="removeFilter('{{ $badge['type'] }}', {{ $badge['id'] }})" class="hover:bg-gray-200 hover:text-gray-900 p-0.5 rounded transition-colors focus:outline-none cursor-pointer" title="Hapus filter">
                                                    <i class="ph ph-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <button type="button" wire:click="clearAllFilters" class="text-xs text-red-700 border rounded-full font-medium ml-auto px-3 py-2 cursor-pointer transition-colors hover:bg-red-700 hover:text-gray-100">
                                Hapus Semua
                            </button>
                        </div>
                    @endif

                    <div class="flex flex-col gap-4">
                        
                        @forelse ($this->datasets as $dataset)                        
                        <livewire:dataset-card :$dataset :wire:key="$dataset->id" />
                        @empty
                        <div class="flex flex-col items-center justify-center py-20 px-6 bg-white rounded-xl border border-gray-100 shadow-sm text-center mt-4">
        
                            <i class="ph ph-file-magnifying-glass text-7xl text-slate-300 mb-5"></i>
                            
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Dataset Tidak Ditemukan</h3>
                            
                            <p class="text-slate-500 max-w-md mx-auto mb-8 leading-relaxed">
                                Maaf, kami tidak dapat menemukan dataset yang sesuai dengan kata kunci atau filter yang Anda terapkan. Silakan coba kriteria pencarian yang berbeda.
                            </p>
                            
                            <button wire:click="clearAllFilters" class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-100 transition-all">
                                <i class="ph ph-arrows-clockwise"></i>
                                Reset Semua Filter
                            </button>
    
                        </div>
                        @endforelse
    
                    </div>

                    <div class="border-t border-gray-200 pt-6 mt-4">
                        {{ $this->datasets->links() }}
                    </div>

                </div>
            
            </main>
        </div>
    </div>
    
</div>
