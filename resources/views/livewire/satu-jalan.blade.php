<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shrink-0">
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
                            <span class="text-slate-700 font-medium ml-1">Satu Jalan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Satu Jalan</h1>
                    <p class="text-sm text-slate-600 mt-1">
                        Direction rute jalan dari Point A ke Point B menggunakan OpenStreetMap dan Leaflet Routing Machine.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col lg:flex-row gap-6" style="height: calc(100vh - 160px); min-height: 650px;">
        
        <!-- Left Sidebar: Road List -->
        <aside class="w-full lg:w-96 bg-white rounded-xl shadow-sm border border-gray-200 flex-col overflow-hidden shrink-0 flex-shrink-0">
            <div class="p-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="ph ph-road text-brand-600 text-lg"></i> Daftar Rute Jalan
                </h2>
                <span class="bg-brand-100 text-brand-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ count($roads) }} Total
                </span>
            </div>

            <div class="grow overflow-y-auto p-4 space-y-2">
                @forelse ($roads as $road)
                    <button
                        wire:click="selectRoad('{{ $road['id'] }}')"
                        class="w-full flex items-center gap-3 p-3 rounded-lg border transition-all duration-200
                            {{ $selectedRoad === $road['id'] ? 'bg-brand-50 border-brand-200 shadow-sm' : 'border-transparent hover:bg-gray-50 hover:border-gray-200' }}"
                    >
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $selectedRoad === $road['id'] ? 'bg-brand-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            <i class="ph ph-map-pin text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-slate-800 leading-tight truncate">{{ $road['name'] }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ ucfirst(str_replace('_', ' ', $road['type'])) }}
                                </span>
                                <span class="ml-2">({{ count($road['coordinates']) }} titik)</span>
                            </div>
                        </div>
                        <i class="ph ph-chevron-right text-slate-400 text-xs"></i>
                    </button>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <p>Belum ada data rute jalan.</p>
                    </div>
                @endforelse
            </div>
        </aside>

        <!-- Right Map Area -->
        <main class="grow bg-white rounded-xl shadow-sm border border-gray-200 relative overflow-hidden min-h-0 flex flex-col flex-shrink-0">
            <div class="absolute top-4 left-4 right-4 md:right-auto md:w-80 z-400 flex items-center gap-2">
                <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden flex">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="mapType" value="default" class="peer hidden" />
                        <div class="px-3 py-2 border-r border-slate-100 text-slate-600 text-xs font-medium hover:bg-slate-50 peer-checked:bg-brand-50 peer-checked:text-brand-700 transition-colors">
                            Jalan
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="mapType" value="satelite" class="peer hidden" />
                        <div class="px-3 py-2 border-r border-slate-100 text-slate-600 text-xs font-medium hover:bg-slate-50 peer-checked:bg-brand-50 peer-checked:text-brand-700 transition-colors">
                            Satelit
                        </div>
                    </label>
                </div>
                <button class="bg-white rounded-lg shadow-sm p-2 flex items-center border border-slate-100 text-slate-600 hover:text-brand-600 transition" title="Lokasi Saya">
                    <i class="ph ph-crosshair text-lg"></i>
                </button>
            </div>

            <div id="satuJalanMap" class="w-full h-full z-0" style="height: 100%; min-height: 600px;" wire:ignore></div>

            <!-- Route Info Overlay -->
            <div class="absolute bottom-4 left-4 right-4 md:right-auto md:w-80 z-300">
                <div class="bg-white/90 backdrop-blur-md rounded-lg shadow-sm border border-gray-200 p-4">
                    @if ($selectedRoad)
                        @php
                            $selected = collect($roads)->firstWhere('id', $selectedRoad);
                        @endphp
                        @if ($selected)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-brand-100 text-brand-600 flex-shrink-0">
                                    <i class="ph ph-route text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-slate-800">{{ $selected['name'] }}</h3>
                                    <p class="text-sm text-slate-500 mt-0.5">
                                        Kategori: {{ ucfirst(str_replace('_', ' ', $selected['type'])) }} |
                                        Warna: <span class="font-mono text-xs">{{ $selected['warna'] }}</span> |
                                        Titik: {{ count($selected['coordinates']) }}
                                    </p>
                                    <div class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $selected['warna'] }};"></span>
                                            Garis rute: {{ $selected['warna'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-slate-500 text-sm py-4">
                            Pilih jalan dari daftar di kiri untuk menampilkan rute direction.
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Leaflet CSS (wajib untuk render peta) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet Routing Machine JS -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <script>
        (function () {
            'use strict';

            var map = null;
            var routingControl = null;
            var markers = [];
            var roadsData = @js($roads);
            var initialRoadId = @js($selectedRoad);

            // Warna sesuai kategori jalan
            function getColorByType(type) {
                switch (type) {
                    case 'jalan_nasional': return '#dc2626';
                    case 'jalan_provinsi': return '#e11d48';
                    case 'jalan_kabupaten': return '#2563eb';
                    default: return '#0f766e';
                }
            }

            function formatDistance(meters) {
                if (meters >= 1000) {
                    return (meters / 1000).toFixed(1) + ' km';
                }
                return meters.toFixed(0) + ' m';
            }

            function formatDuration(seconds) {
                var minutes = Math.round(seconds / 60);
                if (minutes >= 60) {
                    var hours = Math.floor(minutes / 60);
                    var mins = minutes % 60;
                    return hours + ' jam ' + mins + ' menit';
                }
                return minutes + ' menit';
            }

            // Inisialisasi peta Leaflet
            function initMap() {
                if (map) return;

                console.log('Initializing Leaflet map...');

                map = L.map('satuJalanMap', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView([-4.4447, 104.5126], 10);

                // OpenStreetMap tile layer (ODbL license)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                console.log('Map initialized, loading Way Kanan boundary...');

                // Load Way Kanan boundary
                fetch('waykanan.geojson')
                    .then(function (response) {
                        if (!response.ok) throw new Error("Gagal memuat GeoJSON");
                        return response.json();
                    })
                    .then(function (data) {
                        console.log('Way Kanan GeoJSON loaded:', data.features.length, 'features');
                        var wayKananLayer = L.geoJSON(data, {
                            filter: function (feature) {
                                return feature.geometry.type !== 'Point';
                            },
                            style: function (feature) {
                                return {
                                    color: "#e11d48",
                                    weight: 2,
                                    opacity: 0.7,
                                    fillColor: "#e11d48",
                                    fillOpacity: 0.15
                                };
                            }
                        }).addTo(map);
                        map.fitBounds(wayKananLayer.getBounds());
                        console.log('Way Kanan layer added to map');
                    })
                    .catch(function (error) {
                        console.error('Error loading Way Kanan boundary:', error);
                    });
            }

            function clearRoute() {
                if (routingControl) {
                    map.removeControl(routingControl);
                    routingControl = null;
                }
                markers.forEach(function (m) { map.removeLayer(m); });
                markers = [];
                var summaryBox = document.getElementById('route-summary-box-outer');
                if (summaryBox) summaryBox.remove();
            }

            function renderRoute(road) {
                if (!map) initMap();

                clearRoute();

                var coords = road.coordinates;
                if (!coords || coords.length < 2) {
                    console.error('Invalid coordinates for road:', road.name);
                    return;
                }

                console.log('Rendering route:', road.name, 'with', coords.length, 'points');

                // Build waypoints: Point A (start), via points, Point B (destination)
                var waypoints = coords.map(function (c) {
                    return L.latLng(c[0], c[1]);
                });

                // Add start and destination markers
                var startCoord = coords[0];
                var endCoord = coords[coords.length - 1];

                var startMarker = L.marker([startCoord[0], startCoord[1]], {
                    title: 'Titik A (Awal): ' + road.name,
                    draggable: false,
                    icon: L.divIcon({
                        className: 'custom-start-marker',
                        html: '<div style="width:18px;height:18px;background:#dc2626;border:3px solid white;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,0.3);"></div>',
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    })
                }).addTo(map);
                startMarker.bindPopup('<b>📍 Titik A (Awal)</b><br>' + road.name);
                markers.push(startMarker);

                var endMarker = L.marker([endCoord[0], endCoord[1]], {
                    title: 'Titik B (Tujuan): ' + road.name,
                    draggable: false,
                    icon: L.divIcon({
                        className: 'custom-end-marker',
                        html: '<div style="width:18px;height:18px;background:#2563eb;border:3px solid white;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,0.3);"></div>',
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    })
                }).addTo(map);
                endMarker.bindPopup('<b>🏁 Titik B (Tujuan)</b><br>' + road.name);
                markers.push(endMarker);

                // Create routing control (LRM) with category color
                var routeColor = getColorByType(road.type);
                console.log('Route color:', routeColor);

                routingControl = L.Routing.control({
                    waypoints: waypoints,
                    routeWhileDragging: false,
                    show: false,
                    showAlternatives: false,
                    addWaypoints: false,
                    draggableWaypoints: false,
                    fitBestRoutes: true,
                    lineOptions: {
                        styles: [{ color: routeColor, weight: 7, opacity: 0.9 }]
                    },
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    createMarker: function () {
                        return null;
                    }
                }).addTo(map);

                map.once('routesfound', function (e) {
                    var route = e.route[0];
                    var distance = formatDistance(route.summary.totalDistance);
                    var duration = formatDuration(route.summary.totalTime);

                    console.log('Route found:', distance, duration);

                    map.fitBounds(route.bounds, { padding: [60, 60] });

                    // Add route summary box
                    var summaryHtml = '<div class="route-summary-box" id="route-summary-box">' +
                        '<div class="route-line">' +
                        '<div class="color-dot" style="background:' + routeColor + '"></div>' +
                        '<span style="font-weight:600;color:#1f2937;">' + road.name + '</span>' +
                        '</div>' +
                        '<div class="route-stats">' +
                        '<div class="stat-item">' +
                        '<div class="stat-value">' + distance + '</div>' +
                        '<div class="stat-label">Jarak</div>' +
                        '</div>' +
                        '<div class="stat-item">' +
                        '<div class="stat-value">' + duration + '</div>' +
                        '<div class="stat-label">Estimasi waktu</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    var box = document.createElement('div');
                    box.innerHTML = summaryHtml;
                    box.style.position = 'absolute';
                    box.style.bottom = '90px';
                    box.style.left = '4px';
                    box.style.right = '4px';
                    box.style.zIndex = '500';
                    box.style.width = '300px';
                    box.style.margin = '0 auto';
                    box.id = 'route-summary-box-outer';
                    document.getElementById('satuJalanMap').parentNode.insertBefore(box, document.getElementById('satuJalanMap').nextSibling);
                });

                map.once('routeerror', function (e) {
                    console.error('Route error:', e);
                });
            }

            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function () {
                console.log('DOM loaded, initializing map...');
                initMap();

                if (initialRoadId) {
                    var road = roadsData.find(function (r) { return r.id === initialRoadId; });
                    if (road) {
                        renderRoute(road);
                    }
                }
            });

            // Listen for Livewire selectRoad event
            window.addEventListener('livewire:load', function () {
                console.log('Livewire loaded');
                Livewire.on('selectRoad', function (roadId) {
                    console.log('Select road:', roadId);
                    var road = roadsData.find(function (r) { return r.id === roadId; });
                    if (road) {
                        renderRoute(road);
                    }
                });
            });
        })();
    </script>
</div>
