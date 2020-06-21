var mymap = L.map("mapid", {
    center: [-7.7489462,110.5110926],
    zoom: 12,
    scrollWheelZoom: false,
});

var tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);
