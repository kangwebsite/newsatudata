<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-6 shrink-0 relative overflow-hidden">
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
                            <span class="text-slate-700 font-medium ml-1">Metadata</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 leading-tight mb-2">Daftar Kegiatan Statistik Sektoral</h1>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kumpulan informasi metadata (data tentang data) dari berbagai kegiatan penyelenggaraan statistik sektoral oleh OPD di lingkungan Pemerintah Kabupaten Way Kanan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        
        <div class="bg-white rounded-t-xl border border-gray-200 border-b-0 p-4 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="relative w-full md:w-96">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                <input type="search" wire:model.live="search" placeholder="Cari nama kegiatan atau produsen data..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">

                <div x-data="{open:false}" class="relative w-full sm:w-48">
                    <button @click="open=!open" class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2.5 sm:py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition cursor-pointer">                        
                        <span>
                            {{ $tahun == '' ? 'Semua Tahun' : $tahun }}
                        </span>
                        <i class="ph ph-caret-down text-slate-400"></i>
                    </button>
                    
                    <div x-show="open" x-cloak x-transition.opacity @click.outside="open=false" class="absolute right-0 z-20 mt-2 w-full max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg">
                        <button x-on:click="open = false" wire:click="$set('tahun', '')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                            Semua Tahun
                        </button>
                        @foreach(range(2020, 2027) as $year)
                            <button x-on:click="open = false" wire:click="$set('tahun', '{{ $year }}')" class="block w-full px-3 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition cursor-pointer">
                            {{ $year }}
                            </button>
                        @endforeach
                        
                    </div>
                </div>

            </div>
        </div>

        
        <div class="bg-white border border-gray-200 rounded-b-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Nama Kegiatan</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Tahun</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Sektor Kegiatan</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Jenis Statistik</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Produsen Data</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800">Identitas Rekomendasi</th>
                            <th scope="col" class="px-5 py-4 font-bold text-slate-800 text-end">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-100 text-slate-600">

                        @forelse ($this->metadatas as $metadata)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 font-medium text-slate-800 whitespace-normal min-w-62.5">{{ $metadata->name }}</td>
                            <td class="px-5 py-4">{{ $metadata->tahun }}</td>
                            <td class="px-5 py-4">{{ $metadata->sektor_kegiatan }}</td>
                            <td class="px-5 py-4">{{ $metadata->jenis_statistik }}</td>
                            <td class="px-5 py-4 whitespace-normal min-w-50">{{ $metadata->user->name }}</td>
                            <td class="px-5 py-4">{{ $metadata->identitas_rekomendasi }}</td>
                            <td class="px-5 py-4 text-end">
                                <a href="/metadata/{{ $metadata->id }}" wire:navigate class="border-2 border-brand-700 hover:border-white text-brand-700 hover:bg-brand-700 hover:text-white px-6 py-1.5 rounded-full text-xs font-medium transition shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                            
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-20 text-center bg-white">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ph ph-x-circle text-6xl text-slate-300 mb-3"></i>
                                    <p class="text-slate-800 font-medium text-lg">Tidak ada data yang ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            
            
            @if ($this->metadatas->hasPages())
                <div class="px-5 py-4 border-t border-gray-200 bg-white">
                    {{ $this->metadatas->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
