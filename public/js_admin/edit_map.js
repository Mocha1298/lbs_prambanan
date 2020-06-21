var lng = document.getElementById("bujur2").value;
var lat = document.getElementById("lintang2").value;

var mymap2 = L.map("mapid2", {
    center: [lat,lng],
    zoom: 12,
    scrollWheelZoom: false,
});

var tiles2 = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap2);

// Marker Current
var current = L.icon({
    iconUrl: '/gambar/marker/current.png',

    iconSize:     [17, 17], // size of the icon
    iconAnchor:   [20, 10], // point of the icon which will correspond to marker's location
    popupAnchor:  [-13, -5], // point from which the popup should open relative to the iconAnchor
    tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
});

L.marker([lat,lng],{icon:current})
.addTo(mymap2)
.bindPopup("Lokasi terkini");

function getcenter2(){
    var center = mymap2.getCenter();
    document.getElementById("bujur2").value = center.lng;
    document.getElementById("lintang2").value = center.lat;
}
