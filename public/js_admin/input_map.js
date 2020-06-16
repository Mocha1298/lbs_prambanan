var mymap = L.map("mapid1", {
    center: [-7.7489462,110.5110926],
    zoom: 12,
    scrollWheelZoom: false,
});

L.DomUtil.addClass(mymap._container,'crosshair-cursor-enabled');

var tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("Anda menandai lokasi ini")
        .openOn(mymap);
    document.getElementById("bujur1").value = e.latlng.lng.toString();
    document.getElementById("lintang1").value = e.latlng.lat.toString();
}

mymap.on("click", onMapClick);
