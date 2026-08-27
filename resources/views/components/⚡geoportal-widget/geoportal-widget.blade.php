<section class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Geospasial</h2>
    
    <div class="flex flex-col lg:flex-row gap-4 h-112.5">

        <div class="w-full lg:w-64 bg-white rounded-xl shadow-card border border-gray-100 flex flex-col overflow-hidden shrink-0">
            <div class="bg-brand-700 text-white p-3 font-semibold text-sm flex items-center gap-2">
                <i class="ph ph-layers"></i> Semua Layer
            </div>
            <div class="p-2 overflow-y-auto grow space-y-2 hide-scroll">

                @foreach ($this->allGeoTypes as $geoType)                    
                    <label class="flex items-center gap-2 p-2 rounded-lg cursor-pointer text-sm text-slate-700 transition-colors hover:bg-slate-100 has-[input:checked]:bg-slate-100">
                        <input type="checkbox" class="form-checkbox" id="geo{{ $geoType['id'] }}" wire:model.live="selected.{{ $geoType['id'] }}">
                        <img src="{{ url('storage/' . $geoType['icon']) }}" class="h-8" /> {{ $geoType['name'] }}
                    </label>
                @endforeach

            </div>
        </div>

        
        <div class="grow bg-slate-200 rounded-xl relative overflow-hidden shadow-inner min-h-75">
            
            <div id="map" class="w-full h-full z-0" wire:ignore></div>
            

            <div class="absolute bottom-6 right-6 flex flex-col gap-2 bg-white rounded-lg shadow-md p-1">
                <button id="zoomIn" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded text-slate-600 border-b border-gray-100"><i class="ph ph-plus"></i></button>
                <button id="zoomOut" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded text-slate-600 border-b border-gray-100"><i class="ph ph-minus"></i></button>
                <button id="myLocation" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded text-slate-600 border-b border-gray-100"><i class="ph ph-crosshair-simple"></i></button>
                <button id="toggleLayer" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded text-slate-600"><i class="ph ph-stack"></i></button>
            </div>

        </div>

        
        <div class="w-full lg:w-64 bg-white rounded-xl shadow-card border border-gray-100 p-5 flex flex-col justify-between shrink-0">
            <div>
                <h3 class="font-bold text-slate-800 mb-2">Informasi Peta</h3>
                <p class="text-xs text-slate-600 mb-6 leading-relaxed">
                    Peta interaktif data dan potensi daerah Kabupaten Way Kanan
                </p>
                
                <div class="bg-brand-50 p-3 px-6 rounded-lg flex items-center gap-3">
                    <div>
                        <div class="text-xl font-bold text-slate-800">{{ $total }}</div>
                        <div class="text-[10px] text-slate-500 uppercase tracking-wide">Total Layer</div>
                    </div>
                </div>
            </div>
            
            <button wire:click="toGeoportal" class="w-full bg-brand-700 hover:bg-brand-800 text-white py-2.5 rounded-lg text-sm font-medium transition mt-4">
                Buka di Peta Lengkap
            </button>
        </div>
        
    </div>
</section>