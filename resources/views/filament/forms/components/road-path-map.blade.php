@php
$id = $attributes->get('id', 'road-path-map') ?? 'road-path-map';
$value = old($attributes->get('statePath') ?? 'path_coordinates') ?? $attributes->get('state') ?? '';
@endphp

<div wire:ignore class="space-y-2">
    <label for="{{ $id }}" class="text-sm font-medium text-slate-700">Rute jalan (gambar pada peta)</label>
    <div class="relative">
        <div id="{{ $id }}-map" class="w-full h-64 rounded-lg border border-gray-300"></div>
        <input type="hidden" name="{{ $attributes->get('statePath') ?? 'path_coordinates' }}" id="{{ $id }}-input"
               value="{{ $value }}"
               {{ $attributes->except(['id', 'statePath', 'state'])->toHtml() }}>
    </div>
    <p class="text-xs text-gray-500 mt-1">
        Klik pada peta untuk menggambar rute jalan. Titik pertama dan terakhir akan menjadi
        titik A dan B. Klik titik terakhir lagi untuk selesai menggambar.
    </p>
</div>

@pushOnce('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
<script>
    (function () {
        var mapId = '{{ $id }}';
        var mapEl = document.getElementById(mapId + '-map');
        var inputEl = document.getElementById(mapId + '-input');

        if (!mapEl || !inputEl) return;

        var map = L.map(mapId, { zoomControl: true }).setView([-4.4447, 104.5126], 12);

        L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            attribution: 'Google Maps'
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            edit: { featureGroup: drawnItems },
            draw: {
                polyline: {
                    shapeOptions: { color: '#0f766e', weight: 4 },
                    allowIntersection: false,
                    showLength: true,
                    metric: true,
                    repeatMode: false
                },
                polygon: false,
                circle: false,
                rectangle: false,
                marker: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        // Load existing value if any
        var existing = inputEl.value.trim();
        if (existing) {
            try {
                var coords = JSON.parse(existing);
                if (Array.isArray(coords) && coords.length >= 2) {
                    var latlngs = coords.map(function (c) { return [c[0], c[1]]; });
                    var poly = L.polyline(latlngs, { color: '#0f766e', weight: 4 });
                    drawnItems.addLayer(poly);
                    map.fitBounds(poly.getBounds());
                }
            } catch (e) {
                console.warn('Invalid path_coordinates JSON', e);
            }
        }

        map.on(L.Draw.Event.CREATED, function (e) {
            drawnItems.clearLayers();
            var layer = e.layer;
            drawnItems.addLayer(layer);
            var latlngs = layer.getLatLngs();
            var coords = latlngs.map(function (l) { return [l.lat, l.lng]; });
            inputEl.value = JSON.stringify(coords);
            inputEl.dispatchEvent(new Event('input', { bubbles: true }));
        });

        map.on(L.Draw.Event.EDITED, function (e) {
            var latlngs = [];
            e.layers.eachLayer(function (layer) {
                if (layer instanceof L.Polyline) {
                    latlngs = layer.getLatLngs();
                }
            });
            var coords = latlngs.map(function (l) { return [l.lat, l.lng]; });
            inputEl.value = JSON.stringify(coords);
            inputEl.dispatchEvent(new Event('input', { bubbles: true }));
        });

        map.on(L.Draw.Event.DELETED, function () {
            inputEl.value = '';
            inputEl.dispatchEvent(new Event('input', { bubbles: true }));
        });
    })();
</script>
@endpushOnce
