<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }" x-init="window.turnstileCallback = function (token) { state = token; }" wire:ignore>
        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-callback="turnstileCallback"></div>
    </div>
</x-dynamic-component>