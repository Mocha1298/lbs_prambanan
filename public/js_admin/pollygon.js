var mymap = L.map("mapid", {
    center: [-7.7489462,110.5110926],
    zoom: 12,
    scrollWheelZoom: false,
});

// L.geoJSON([bugisan]).addTo(mymap);

var tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 15,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);

// BAGIAN CUSTOM MARKER NYA

// Marker Selesai
var finn = L.icon({
    iconUrl: '/be_aset/dist/img/marker/marker-hijau.png',

    iconSize:     [40, 46], // size of the icon
    iconAnchor:   [10, 37], // point of the icon which will correspond to marker's location
    popupAnchor:  [10, -25], // point from which the popup should open relative to the iconAnchor
    tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
});

// Marker Sedang
var fix = L.icon({
    iconUrl: '/be_aset/dist/img/marker/fix.png',

    iconSize:     [45,45], // size of the icon
    iconAnchor:   [15, 37], // point of the icon which will correspond to marker's location
    popupAnchor:  [7, -25], // point from which the popup should open relative to the iconAnchor
    tooltipAnchor: [10,-10], //Alhamdulillah nemu bind tool up e aku :D
});


// Marker Rencana
var plan = L.icon({
    iconUrl: '/be_aset/dist/img/marker/marker-merah.png',

    iconSize:     [54, 48], // size of the icon
    iconAnchor:   [10, 37], // point of the icon which will correspond to marker's location
    popupAnchor:  [4, -25], // point from which the popup should open relative to the iconAnchor
    tooltipAnchor: [3,-23], //Alhamdulillah nemu bind tool up e aku :D
});
 