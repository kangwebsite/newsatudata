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
                            <a href="/publikasi" wire:navigate class="hover:text-brand-700 transition ml-1 text-slate-500 font-medium">Publikasi</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1 line-clamp-1">{{ $this->post->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="grow">
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight mb-3">{{ $this->post->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm text-slate-600">
                        <div class="flex items-center gap-1.5">
                            <i class="ph ph-clock text-slate-400"></i>
                            <span>Diperbarui {{ $this->post->updated_at->translatedFormat('j F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="ph ph-eye text-slate-400"></i>
                            <span>Dilihat {{ number_format($this->post->viewCount, 0, '.', '.') }} kali</span>
                        </div>
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

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-10">
            
            
            <article class="grow">
                
                
                <div class="rounded-2xl overflow-hidden mb-8 shadow-sm border border-gray-200">
                    <img src="{{ url('storage/' . $this->post->image) }}" alt="Bupati Membuka Acara Bimtek" class="w-full h-auto object-cover aspect-video">
                </div>

                
                <div class="article-content text-lg">
                    {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($this->post->body) }}
                </div>

                
                <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-3">
                    <span class="text-sm font-bold text-slate-700"><i class="ph ph-tag"></i> Tag:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($this->post->tags as $tag)                            
                        <a href="/publikasi/tag/{{ Str::slug($tag) }}" wire:navigate class="px-3 py-1 bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-700 text-xs font-medium rounded-lg transition">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>

                
                <div class="mt-12 bg-slate-50 p-6 rounded-2xl border border-gray-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="ph ph-books text-brand-600"></i> Baca Juga
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        @foreach ($this->bacaJuga as $baca)                            
                        <a href="/publikasi/post/{{ $baca->slug }}" wire:navigate class="group flex gap-4 bg-white p-3 rounded-xl border border-gray-100 hover:border-brand-300 hover:shadow-md transition">
                            <img src="{{ url('storage/' . $baca->image) }}" alt="Thumb" class="w-20 h-20 rounded-lg object-cover shrink-0 group-hover:scale-105 transition">
                            <div class="flex flex-col justify-center">
                                <span class="text-[10px] text-slate-400 mb-1">{{ $baca->created_at->translatedFormat('j F Y') }}</span>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-brand-700 line-clamp-2 leading-snug">{{ $baca->title }}</h4>
                            </div>
                        </a>
                        @endforeach
                        
                    </div>
                </div>

            </article>

            <aside class="w-full lg:w-80 shrink-0 space-y-6">

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                        <i class="ph ph-fire text-orange-500"></i> Populer
                    </h3>
                    <div class="space-y-4">
                        
                        @foreach ($this->popularPosts as $popular)
                        <a href="/publikasi/post/{{ $popular->slug }}" wire:navigate class="flex gap-3 group cursor-pointer">
                            <div class="w-16 h-16 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
                                <img src="{{ url('storage/' . $popular->image) }}" alt="Thumb" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-xs font-bold text-slate-700 group-hover:text-brand-700 line-clamp-2 leading-snug mb-1">{{ $popular->title }}</h4>
                                <span class="text-[10px] text-slate-400 flex items-center gap-1"><i class="ph ph-eye"></i> {{ number_format($popular->viewCount, 0, '.', '.') }}x</span>
                            </div>
                        </a>
                        @endforeach
                        
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                        <i class="ph ph-hash text-brand-600"></i> Label / Tags
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($this->tags as $tag)
                            <a href="/publikasi/tag/{{ Str::slug($tag) }}" wire:navigate class="px-2.5 py-1 bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-700 border border-transparent hover:border-brand-200 text-xs rounded transition">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>

            </aside>

        </div>
    </main>
</div>
