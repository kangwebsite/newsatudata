@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-default">
                    Sebelumnya
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    Sebelumnya
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    Berikutnya
                </button>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-default">
                    Berikutnya
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-slate-500 leading-5">
                    Menampilkan
                    <span class="font-medium text-slate-700">{{ $paginator->firstItem() }}</span>
                    hingga
                    <span class="font-medium text-slate-700">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium text-slate-700">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-lg shadow-sm">
                    
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-default rounded-l-lg leading-5">
                            <i class="ph ph-caret-left"></i>
                        </span>
                    @else
                        <button wire:click="previousPage" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-l-lg leading-5 hover:text-slate-700 hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-brand-500 transition ease-in-out duration-150" aria-label="Previous">
                            <i class="ph ph-caret-left"></i>
                        </button>
                    @endif

                    @foreach ($elements as $element)
                        
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-500 bg-white border border-slate-200 cursor-default leading-5">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-brand-700 bg-brand-50 border border-brand-200 cursor-default leading-5 z-10">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-600 bg-white border border-slate-300 leading-5 hover:text-brand-600 hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-brand-500 transition ease-in-out duration-150" aria-label="Go to page {{ $page }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-r-lg leading-5 hover:text-slate-700 hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-brand-500 transition ease-in-out duration-150" aria-label="Next">
                            <i class="ph ph-caret-right"></i>
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="Next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-default rounded-r-lg leading-5">
                            <i class="ph ph-caret-right"></i>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif