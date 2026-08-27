<div>
    <livewire:hero-banner />
    <livewire:summary-stats-home />
    <livewire:data-sektoral-widget />
    {{-- <livewire:indikator-daerah-widget /> --}}

    <livewire:geoportal-widget />

    <section class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <livewire:latest-dataset-widget />

            <livewire:latest-news-widget />
            

            <div class="bg-white rounded-2xl p-6 shadow-gray-200 shadow-lg border border-slate-100 font-sans">    
                <h3 class="text-xl font-bold text-slate-800 mb-2">Layanan API</h3>                
                <p class="text-sm text-slate-600 mb-6 leading-relaxed pr-4">
                    Akses data Way Kanan melalui API untuk kebutuhan aplikasi dan analisis Anda.
                </p>
                <div class="flex justify-between items-start gap-4 mb-8">                    
                    <ul class="space-y-2.5 flex-1">
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">RESTful API</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">JSON & XML Format</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">API Documentation</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">API Explorer</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">API Key Management</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ph ph-check-circle text-2xl text-slate-500 shrink-0"></i>
                            <span class="text-sm text-slate-700 font-medium">Rate Limit & Quota</span>
                        </li>
                    </ul>

                    <div class="w-42 shrink-0 mt-2">
                        <img src="{{ url('storage/api-service.png') }}" alt="Ilustrasi API" class="w-full h-auto object-contain">
                    </div>
                    
                </div>

                <a href="/dokumentasi" wire:navigate class="inline-block bg-brand-700 hover:bg-brand-800 text-white font-semibold text-sm px-5 py-2.5 rounded-lg transition-colors">
                    Kunjungi API Center
                </a>

            </div>

        </div>
    </section>
</div>
