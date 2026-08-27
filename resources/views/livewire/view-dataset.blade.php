<div>
    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-gray-200 pt-6 pb-4">
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8">
            
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
                            <a href="/dataset" wire:navigate class="hover:text-brand-700 transition ml-1 text-slate-500 font-medium">Katalog Dataset</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1 line-clamp-1">{{ $this->dataset->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="grow">
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight mb-3">{{ $this->dataset->name }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm text-slate-600">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full bg-brand-50 flex items-center justify-center text-brand-600">
                                <i class="ph ph-buildings"></i>
                            </div>
                            <span class="font-medium text-slate-700">{{ $this->dataset->uploadBy->name }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="ph ph-clock text-slate-400"></i>
                            <span>Diperbarui {{ $this->dataset->updated_at->translatedFormat('j F Y') }}</span>
                        </div>
                        {{-- <div class="flex items-center gap-1.5">
                            <i class="ph ph-eye text-slate-400"></i>
                            <span>Dilihat 1.245 kali</span>
                        </div> --}}
                    </div>
                </div>
                
                
                <div class="flex gap-2 shrink-0">
                    <button 
                        x-data="{
                            shareData: {
                                title: document.title,
                                url: window.location.href
                            },
                            sharePage() {
                                if (navigator.share) {
                                    navigator.share(this.shareData).catch(() => {});
                                } else {
                                    navigator.clipboard.writeText(this.shareData.url);
                                    alert('Tautan halaman disalin ke clipboard!');
                                }
                            }
                        }"
                        @click="sharePage()"
                        type="button" 
                        class="bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 cursor-pointer hover:border-brand-600 hover:text-brand-600"
                    >
                        <i class="ph ph-share-network"></i> Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <main class="col-span-1 lg:col-span-2">
                @if ($this->dataset->typeData->name !== 'Buku')
                <div x-data="{ activeTab: 'section1' }" class="flex flex-col gap-3 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
                    <div class="p-3 flex items-center gap-1 border-b pb-3 bg-slate-50 border-slate-100">
                        <button @click="activeTab = 'section1'" :class="activeTab === 'section1' ? 'bg-brand-600 text-white shadow' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'" class="px-5 py-2 text-sm font-semibold rounded-lg transition-all focus:outline-none cursor-pointer flex items-center gap-1"><i class="ph ph-table text-lg"></i> Table</button>
                        @if ($this->dataset->typeData->name === 'Grafik')                            
                        <button @click="activeTab = 'section2'" :class="activeTab === 'section2' ? 'bg-brand-600 text-white shadow' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'" class="px-5 py-2 text-sm font-semibold rounded-lg transition-all focus:outline-none cursor-pointer flex items-center gap-1"><i class="ph ph-chart-bar text-lg"></i> Grafik</button>
                        @endif
                    </div>

                    <div class="p-3">
                        
                        <div x-show="activeTab === 'section1'" x-cloak>
                            <livewire:dataset-excel-viewer :$dataset />
                            <div class="p-3 border-t border-gray-100 text-center text-xs text-slate-500">
                                Data di atas kemungkinan hanya sebagian data. Silakan unduh untuk melihat data lengkap.
                            </div>
                        </div>

                        @if ($this->dataset->typeData->name === 'Grafik')
                        <div x-show="activeTab === 'section2'" x-cloak>
                            <div class="h-full [&_.fi-section]:bg-transparent [&_.fi-section]:shadow-none [&_.fi-section]:ring-0 [&_.fi-section-header]:hidden [&_.fi-section-content]:px-0 [&_.fi-section-content]:pb-0 [&_.fi-section-content]:pt-6">
                                @livewire(\App\Livewire\DatasetChart::class, ['dataset' => $this->dataset])
                            </div>
                        </div>
                        @endif
                        
                    </div>

                </div>
                
                @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="p-4 border-b border-gray-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="ph ph-file-pdf text-brand-600 text-lg"></i> PDF Data
                        </h3>
                    </div>
                    <div class="p-3 h-full">
                        <embed src="{{ Storage::url($this->dataset->file) }}" type="application/pdf" class="w-full h-full" />
                    </div>
                </div>
                    
                @endif
                
            </main>

            <aside class="col-span-1 flex flex-col gap-4">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="ph ph-download-simple text-brand-600 text-lg"></i> Unduh Data
                        </h3>
                    </div>
                    <div class="p-3 flex flex-col gap-3">
                        <div class="data-loading:opacity-50 gap-2 flex items-center justify-between p-2 rounded-lg cursor-pointer border border-gray-200 hover:border-brand-300 hover:bg-brand-50 transition group" wire:click="downloadFile">
                            <div class="w-10 h-10 rounded bg-brand-100 text-brand-600 flex items-center justify-center shrink-0">
                                <i class="{{ $this->iconFile }} text-md"></i>
                            </div>
                            <div class="flex flex-col justify-between items-start overflow-hidden grow">
                                <div class="text-xs font-bold text-slate-800 group-hover:text-brand-700 line-clamp-1">{{ $this->file['filename'] }}</div>
                                <div class="text-[10px] text-slate-500">{{ $this->file['filesize'] }}</div>
                            </div>
                            <div class="w-10 h-10 rounded flex items-center justify-center shrink-0">
                                <i class="ph ph-download text-md group-hover:text-brand-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-slate-700">Akses via API (JSON)</span>
                                <a href="/dokumentasi" wire:navigate class="text-[10px] text-brand-600 hover:underline">Dokumentasi <i class="ph ph-arrow-square-out"></i></a>
                            </div>
                            <div x-data="{ copied: false, textToCopy: '/api/v2/dataset/{{ $this->dataset->slug }}' }" class="relative">
                                <div class="bg-slate-800 text-slate-300 text-xs font-mono p-3 pr-12 rounded-lg overflow-hidden whitespace-nowrap overflow-x-auto hide-scroll">
                                    <span x-text="textToCopy"></span>
                                </div>
                                <button 
                                    type="button"
                                    @click="navigator.clipboard.writeText(textToCopy); copied = true; setTimeout(() => copied = false, 2000);"
                                    class="absolute right-1 top-1 bottom-1 bg-slate-700 hover:bg-slate-600 px-3 rounded text-white transition flex items-center justify-center cursor-pointer" 
                                    title="Salin ke clipboard"
                                >
                                    <i x-show="!copied" class="ph ph-copy"></i>
                                    <i x-show="copied" x-cloak class="ph ph-check text-teal-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="ph ph-info text-brand-600 text-lg"></i> Informasi Metadata
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Produsen Data</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->uploadBy->name }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Deskripsi</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->description }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Cakupan Wilayah</th>
                                    <td class="px-4 py-3 text-slate-800">Kabupaten Way Kanan</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Topik Data</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->categoryData->name }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Tipe Data</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->typeData->name }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Frekuensi Rilis</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->periodeData->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Dibuat Pada</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->created_at->translatedFormat('j F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-3 bg-gray-50/50 w-2/5 font-medium text-slate-600">Pembaruan Terakhir</th>
                                    <td class="px-4 py-3 text-slate-800">{{ $this->dataset->updated_at->translatedFormat('j F Y H:i') }} WIB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button wire:click="laporkan" class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-50 py-3 rounded-xl text-sm font-medium transition flex justify-center items-center gap-2 cursor-pointer">
                    <i class="ph ph-warning-circle text-lg"></i> Laporkan Masalah Data
                </button>
            </aside>
        </div>
    </div>

</div>