<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-4 shrink-0">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-slate-500 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" wire:navigate class="hover:text-brand-700 transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1">Peta Geospasial</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Peta Geospasial Terintegrasi</h1>
                    <p class="text-sm text-slate-600 mt-1">Eksplorasi data kewilayahan dan tematik Kabupaten Way Kanan dalam bentuk peta interaktif.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grow max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col lg:flex-row gap-6 h-auto lg:h-187.5">
        
        <!-- Mobile Sidebar Toggle -->
        <button class="lg:hidden w-full bg-white border border-gray-200 text-slate-700 py-2.5 rounded-lg font-medium flex justify-center items-center gap-2 shadow-sm">
            <i class="ph ph-layers"></i> Tampilkan Daftar Layer
        </button>

        <!-- Left Sidebar: Layer Manager -->
        <aside class="hidden lg:flex w-full lg:w-80 bg-white rounded-xl shadow-sm border border-gray-200 flex-col overflow-hidden shrink-0">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="ph ph-stack text-brand-600 text-lg"></i> Pengaturan Map
                </h2>
                <span class="bg-brand-100 text-brand-700 text-[10px] font-bold px-2 py-0.5 rounded-full">135 Total</span>
            </div>
            

            
            <div class="grow overflow-y-auto custom-scrollbar p-4 space-y-1">
                
                
                <label class="flex items-center gap-3 cursor-pointer group mb-4">
                    <input type="checkbox" class="form-checkbox" wire:model.live='polygon'>
                    <i class="ph ph-polygon"></i>
                    <span class="text-sm text-slate-600 group-hover:text-brand-700 transition line-clamp-1">Batas Kabupaten Way Kanan</span>
                </label>
                
                @foreach ($this->allGeoTypes as $geoType)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" class="form-checkbox" id="geo{{ $geoType['id'] }}" wire:model.live="selected.{{ $geoType['id'] }}">
                        <img src="{{ url('storage/' . $geoType['icon']) }}" class="h-8" />
                        <h2 class="font-bold text-slate-800 flex items-center gap-2">{{ $geoType['name'] }}</h2>
                    </label>
                @endforeach
            </div>

            
            <div class="p-4 border-t border-gray-100 bg-white">
                <button class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-lg text-sm font-semibold transition" wire:click='clearFilters'>
                    Bersihkan Semua Filter
                </button>
            </div>
        </aside>

        <main class="grow bg-white rounded-xl shadow-sm border border-gray-200 relative overflow-hidden flex flex-col min-h-100 lg:min-h-0">
    
    
            <div class="absolute top-4 left-4 right-4 md:right-auto md:w-96 z-400 flex item-center gap-2">
                <div class="bg-white rounded-lg shadow-floating border border-slate-100 overflow-hidden flex text-xs font-medium">

                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="mapType" value="default" class="peer hidden" />
                        <div class="px-4 py-2 border-r border-slate-100 text-slate-600 hover:bg-slate-50 peer-checked:bg-brand-50 peer-checked:text-brand-700 transition-colors">
                            Jalan
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="mapType" value="satelite" class="peer hidden" />
                        <div class="px-4 py-2 border-r border-slate-100 text-slate-600 hover:bg-slate-50 peer-checked:bg-brand-50 peer-checked:text-brand-700 transition-colors">
                            Satelit
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="mapType" value="topografi" class="peer hidden" />
                        <div class="px-4 py-2 text-slate-600 hover:bg-slate-50 peer-checked:bg-brand-50 peer-checked:text-brand-700 transition-colors">
                            Topografi
                        </div>
                    </label>

                </div>
                <button class="bg-white rounded-lg shadow-floating p-2 flex items-center border border-slate-100 text-slate-600 hover:text-brand-600 transition" title="Lokasi Saya">
                    <i class="ph ph-crosshair text-lg"></i>
                </button>
            </div>

            <div id="map" class="w-full h-full z-1" wire:ignore></div>
            
        </main>

    </div>
</div>


@script
<script>
    var map = L.map('map', {
        zoomControl: false
    }).setView([-4.4447, 104.5126], 10);

    var layerJalan = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 19, attribution: 'Google Maps'
    });

    var layerSatelit = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 19, attribution: 'Google Satellite'
    });

    var layerTopografi = L.tileLayer('https://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 19, attribution: 'Google Terrain'
    });

    layerJalan.addTo(map);

    $wire.on('change-basemap', (e) => {
        changeBasemap(e[0])
    })

    $wire.on('toggle-poly', (e) => {
        toggleBatasKab(e[0])
    })


    var wayKananLayer;

    fetch('waykanan.geojson')
        .then(response => {
            if (!response.ok) {
                throw new Error("Gagal memuat file GeoJSON");
            }
            return response.json();
        })
        .then(data => {
            
            wayKananLayer = L.geoJSON(data, {
                filter: function (feature) {
                    return feature.geometry.type !== 'Point';
                },
                style: function (feature) {
                    return {
                        color: "#e74c3c",
                        weight: 2,
                        opacity: 1,
                        fillColor: "#e74c3c",
                        fillOpacity: 0.15
                    };
                }
            }).addTo(map);

            map.fitBounds(wayKananLayer.getBounds());
        })
        .catch(error => {
            console.error('Error:', error);
    })

    let markersArray = [];
    renderAgain($wire.geoTypes);
    
    $wire.on('markers-updated', (e) => {
        renderAgain(e[0]);
    });

    function renderAgain(dataGeoTypes) {
        
        markersArray.forEach(marker => marker.remove());
        markersArray = [];

        dataGeoTypes.forEach(item => {
            item.geoportals.forEach(portal => {
                let koordinat = JSON.parse(portal.location);

                if (koordinat && koordinat.length === 2) {
                    let lng = koordinat[0];
                    let lat = koordinat[1];
            
                    let iconPath = '/storage/' + item.icon;
            
                    let customIcon = L.icon({
                        iconUrl: iconPath,
                        iconSize: [18],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -32]
                    });
            
                    let marker = L.marker([lat, lng], { icon: customIcon })
                        .addTo(map)
                        .bindPopup(`<b>${portal.name}</b>`);

                    markersArray.push(marker);
                }
            });
        });
    }

    function toggleBatasKab(isChecked) {
        if (!wayKananLayer) {
            return; 
        }

        if (isChecked) {
            map.addLayer(wayKananLayer);
        } else {
            map.removeLayer(wayKananLayer);
        }
    }
    toggleBatasKab(false)

    function changeBasemap(type) {
        map.removeLayer(layerJalan);
        map.removeLayer(layerSatelit);
        map.removeLayer(layerTopografi);

        if (type === 'default') {
            layerJalan.addTo(map);
        } else if (type === 'satelite') {
            layerSatelit.addTo(map);
        } else if (type === 'topografi') {
            layerTopografi.addTo(map);
        }
    }
</script>
@endscript