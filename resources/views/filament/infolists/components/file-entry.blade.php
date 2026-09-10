<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div {{ $getExtraAttributeBag() }} class="flex flex-col gap-3">

        <div class="flex items-center gap-2">
            <x-filament::icon icon="heroicon-o-document" class="h-10 w-10 text-gray-500 dark:text-gray-400" />
            <div>
                <div class="font-bold">{{ $getState() }}</div>
                <div class="text-gray-500">Format: PDF</div>
            </div>
        </div>
        <x-filament::button wire:click="downloadFile" icon="heroicon-o-arrow-down-tray">Unduh Dokumen</x-filament::button>
    </div>
</x-dynamic-component>
