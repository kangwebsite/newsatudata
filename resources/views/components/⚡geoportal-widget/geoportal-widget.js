var map = L.map('map', {
    zoomControl: false
}).setView([-4.4447, 104.5126], 10);

L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    attribution: 'Satudata Way Kanan',
    maxZoom: 19
}).addTo(map);

let geoJsonUrl = 'waykanan.geojson'; 

fetch(geoJsonUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error("Gagal memuat GeoJSON Way Kanan");
        }
        return response.json();
    })
    .then(data => {
        var wayKananLayer = L.geoJSON(data, {
            style: function (feature) {
                return {
                    color: "#e11d48",
                    weight: 2,
                    opacity: 0.8,
                    fillColor: "#f43f5e",
                    fillOpacity: 0.15
                };
            }
        }).addTo(map);
        map.fitBounds(wayKananLayer.getBounds());
    })
    .catch(error => console.error('Error GeoJSON:', error));
    

document.getElementById('zoomIn').addEventListener('click', function(e) {
    e.preventDefault();
    map.zoomIn();
});

document.getElementById('zoomOut').addEventListener('click', function(e) {
    e.preventDefault();
    map.zoomOut();
});


document.getElementById('myLocation').addEventListener('click', function(e) {
    e.preventDefault();
    map.locate({setView: true, maxZoom: 16});
});

let userMarker;
map.on('locationfound', function(e) {
    if (userMarker) {
        map.removeLayer(userMarker);
    }
    userMarker = L.marker(e.latlng).addTo(map).bindPopup("Lokasi Anda").openPopup();
});

map.on('locationerror', function(e) {
    alert("Gagal mendapatkan akses lokasi.");
});


let layerOSM = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
let layerGoogleTerrain = L.tileLayer('https://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z}');
let layerGoogleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}');
let layerGoogleDefault = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}');

let basemaps = [layerGoogleDefault, layerOSM, layerGoogleTerrain, layerGoogleSatellite];
let currentLayerIndex = 0;

basemaps[0].addTo(map);

document.getElementById('toggleLayer').addEventListener('click', function(e) {
    e.preventDefault();
    map.removeLayer(basemaps[currentLayerIndex]);
    
    currentLayerIndex = (currentLayerIndex + 1) % basemaps.length;
    
    basemaps[currentLayerIndex].addTo(map);
});


let markersArray = [];
let geoTypes = $wire.$get('geoTypes');
renderAgain();

$wire.on('markers-updated', () => {
    renderAgain();
});

function renderAgain() {
    markersArray.forEach(marker => marker.remove());
    markersArray = [];

    geoTypes.forEach(item => {
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