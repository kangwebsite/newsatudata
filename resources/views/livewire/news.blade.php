<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-6 shrink-0">
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="flex text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="index.html" class="hover:text-brand-700 transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1">Berita & Publikasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="max-w-2xl">
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Berita & Publikasi</h1>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                        Kumpulan informasi terbaru, agenda kegiatan, artikel teknis, dan rilis resmi terkait data dan penyelenggaraan Satu Data di Kabupaten Way Kanan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="grow lg:w-2/3 space-y-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-0">
    
                    <div class="grow flex items-center gap-3 px-1 w-full">
                        <i class="ph ph-magnifying-glass text-xl text-slate-400"></i>
                        <input type="search" placeholder="Cari judul publikasi, deskripsi, atau kata kunci..." wire:model.live="query" class="w-full bg-transparent outline-none text-slate-700 text-sm py-1.5">
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
                
                @if($this->news->isNotEmpty())
                    <article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col md:flex-row">
                        <div class="md:w-1/3 relative overflow-hidden">
                            <a href="/publikasi/post/{{ $this->latestPost->slug }}" wire:navigate>
                                <img src="{{ url('storage/' . $this->latestPost->image) }}" alt="Featured Image" class="w-full h-full object-cover min-h-[250px] group-hover:scale-105 transition duration-500">
                            </a>
                            <div class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">Terbaru</div>
                        </div>
                        <div class="p-6 md:w-1/2 flex grow flex-col justify-center">
                            
                            <div class="flex items-center gap-3 mb-3 text-xs text-slate-500 font-medium">                                
                                <span class="flex items-center gap-1"><i class="ph ph-calendar-blank text-slate-400"></i> {{ $this->latestPost->created_at->translatedFormat('j M Y') }}</span>
                                <span class="flex items-center gap-1"><i class="ph ph-eye text-slate-400"></i> {{ number_format($this->latestPost->viewCount, 0, '.', '.') }}x</span>
                            </div>

                            <a href="/publikasi/post/{{ $this->latestPost->slug }}" wire:navigate>
                                <h2 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-brand-700 transition leading-snug">{{ $this->latestPost->title }}</h2>
                                <p class="text-sm text-slate-600 mb-4 line-clamp-3 leading-relaxed">{{ $this->latestPost->excerpt }}</p>
                            </a>
                            
                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @foreach ($this->latestPost->tags as $tag)
                                        @if ($loop->iteration <= 3)
                                            <span class="text-[8px] bg-slate-100 text-gray-600 p-1.5 rounded font-bold uppercase">{{ $tag }}</span>
                                        @elseif ($loop->iteration == 4)
                                            <span class="text-[8px] bg-slate-100 text-gray-600 p-1.5 rounded font-bold uppercase">+ {{ count($this->latestPost->tags) - 3 }} Lainnya</span>
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                                <a href="/publikasi/post/{{ $this->latestPost->slug }}" wire:navigate>
                                    <span class="text-brand-600 text-sm font-semibold hidden md:flex items-center gap-1 group-hover:gap-2 transition-all">Baca selengkapnya<i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endif

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    @foreach ($this->news->skip(1) as $post)   
                        <article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col">
                            <div class="relative overflow-hidden aspect-video">
                                <a href="/publikasi/post/{{ $post->slug }}" wire:navigate>
                                    <img src="{{ url('storage/' . $post->image) }}" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </a>
                            </div>
                            <div class="p-5 flex flex-col grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex items-center gap-1 text-xs text-slate-500">
                                        <i class="ph ph-calendar-blank text-slate-400"></i> {{ $post->created_at->translatedFormat('j M Y') }}
                                    </div>
                                    <div class="flex items-center gap-1 text-xs text-slate-500">
                                        <i class="ph ph-eye text-slate-400"></i> {{ number_format($this->news->first()->viewCount, 0, '.', '.') }}x
                                    </div>
                                </div>
                                <a href="/publikasi/post/{{ $post->slug }}" wire:navigate>
                                    <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-brand-700 transition leading-snug">{{ $post->title }}</h3>
                                </a>
                                <p class="text-sm text-slate-600 line-clamp-3 grow">{{ $post->excerpt }}</p>

                                <div class="flex flex-wrap gap-2 items-center my-4">
                                    @foreach ($post->tags as $tag)
                                        @if ($loop->iteration <= 3)
                                            <span class="text-[8px] bg-slate-100 text-gray-600 p-1.5 rounded font-bold uppercase">{{ $tag }}</span>
                                        @elseif ($loop->iteration == 4)
                                            <span class="text-[8px] bg-slate-100 text-gray-600 p-1.5 rounded font-bold uppercase">+ {{ count($post->tags) - 3 }} Lainnya</span>
                                            @break
                                        @endif
                                    @endforeach
                                </div>

                                <a href="/publikasi/post/{{ $post->slug }}" wire:navigate>
                                    <div class="pt-4 border-t border-gray-100 flex justify-between items-center mt-auto">
                                        <span class="text-xs text-slate-500">Baca Selengkapnya</span></span>
                                        <i class="ph ph-arrow-right text-brand-600"></i>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach

                </div>

                
                {{ $this->news->links() }}

            </div>

            
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
                            <a href="/publikasi/tag/{{ Str::slug($tag) }}" wire:navigate class="px-2.5 py-1 bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-700 border border-transparent hover:border-brand-200 text-xs rounded transition">{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>

            </aside>

        </div>
    </main>
</div>
