var lng = document.getElementById("bujur2").value;
var lat = document.getElementById("lintang2").value;

var mymap = L.map("mapid2", {
    center: [lat,lng],
    zoom: 12,
    scrollWheelZoom: false,
});

L.DomUtil.addClass(mymap._container,'crosshair-cursor-enabled');

var tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);


L.marker([lat,lng]).addTo(mymap).bindPopup("Lokasi terkini")

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("Anda menandai lokasi ini")
        .openOn(mymap);
    document.getElementById("bujur2").value = e.latlng.lng.toString();
    document.getElementById("lintang2").value = e.latlng.lat.toString();
}

mymap.on("click", onMapClick);

