var mymap1 = L.map("mapid1", {
    center: [-7.7489462,110.5110926],
    zoom: 12,
    scrollWheelZoom: false,
});

function getcenter1(){
    var center = mymap1.getCenter();
    
    document.getElementById("bujur1").value = center.lng;
    document.getElementById("lintang1").value = center.lat;
    // document.getElementById("ltln").value = center.lat+','+center.lng;
}

var tiles1 = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap1);
