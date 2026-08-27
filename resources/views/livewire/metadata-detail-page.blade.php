<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-6 shrink-0 relative">
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
                            <a href="/metadata" wire:navigate class="hover:text-brand-700 transition">Metadata</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1 truncate max-w-50 sm:max-w-none">Detail Metadata</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="max-w-4xl">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-brand-50 text-brand-700 border border-brand-100 text-xs font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ $this->metadata->jenis_statistik }}
                        </span>
                        <span class="text-sm font-medium text-slate-500 flex items-center gap-1">
                            <i class="ph ph-identification-badge"></i> {{ $this->metadata->identitas_rekomendasi }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 leading-tight mb-2">
                        Dokumen Metadata: {{ $this->metadata->name }}
                    </h1>
                    <p class="text-sm text-slate-600">
                        Dipublikasikan oleh: <span class="font-semibold text-slate-700">{{ $this->metadata->user->name }}</span> &bull; Tahun {{ $this->metadata->tahun }}
                    </p>
                </div>
                
                <div class="flex shrink-0 gap-3">
                    <button wire:loading.attr="disabled" wire:click="back" class="bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </button>
                    <button wire:loading.attr="disabled" wire:click="download" class="bg-brand-700 hover:bg-brand-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
                        <span class="in-data-loading:hidden"><i class="ph ph-download-simple"></i> Unduh PDF</span>
                        <span class="not-in-data-loading:hidden"><i class="ph ph-spinner animate-spin"></i> Mengunduh...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col">
        
        
        <div class="md:hidden bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-start gap-3">
            <i class="ph ph-info mt-0.5 text-lg"></i>
            <div>Jika dokumen PDF tidak tampil di perangkat Anda, silakan gunakan tombol <strong>Unduh PDF</strong> di atas untuk membaca dokumen.</div>
        </div>

        
        <div class="grow w-full bg-slate-200 rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col min-h-250 relative">
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 z-0">
                <i class="ph ph-spinner animate-spin text-4xl mb-3"></i>
                <span class="text-sm font-medium">Memuat Dokumen PDF...</span>
            </div>
            
            <iframe src="{{ url('storage/' . $this->metadata->file) }}" class="w-full h-full grow border-0 z-10 relative bg-white" title="Dokumen PDF Metadata" loading="lazy"></iframe>
        </div>

    </main>
</div>
