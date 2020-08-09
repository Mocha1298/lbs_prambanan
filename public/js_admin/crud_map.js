var classname = $('tr.table');
var id = '';
var mymap = [];

var old_b = $("#bujur").value;
var old_l = $("#lintang").value;

// Input 
var mymap1

$.getJSON("/center", function (data){
    if (old_b == undefined) {
        mymap1 = L.map('mapid',{
            center :  [data.lintang,data.bujur],
            zoom: 13,
        });
    }
    else{
        mymap1 = L.map('mapid',{
            center :  [old_b,old_l],
            zoom: 13,
        });
    }
    L.geoJSON([prambanan],{
        fillOpacity : 0,
        color : 'white'
    }).addTo(mymap1);
    L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        minZoom: 13,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(mymap1);
});

// L.geoJSON([prambanan]).addTo(mymap1);

// var layer = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
//     maxZoom: 20,
//     minZoom: 13,
//     subdomains:['mt0','mt1','mt2','mt3']
// }).addTo(mymap1);

function getcenter1(){
    var center = mymap1.getCenter();
    
    document.getElementById("bujur").value = center.lng;
    document.getElementById("lintang").value = center.lat;
}




for (let i = 0; i < classname.length; i++) {
    id = $(classname[i]).attr('id');
    var lng = document.getElementById("bujur"+id+"").value;
    var lat = document.getElementById("lintang"+id+"").value;
    
    mymap[id] = L.map("mapid"+id+"", {
        center: [lat,lng],
        zoom: 20,
        scrollWheelZoom: false,
    });

    L.geoJSON([prambanan]).addTo(mymap[id]);
    
    var layer = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    minZoom: 13,
    subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(mymap[id]);

    // Marker Current
    var current = L.icon({
        iconUrl: '/gambar/marker/current.png',
        iconSize:     [17, 17], // size of the icon
        iconAnchor:   [5, 15], // point of the icon which will correspond to marker's location
        popupAnchor:  [-10, -5], // point from which the popup should open relative to the iconAnchor
        tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
    });
    L.marker([lat,lng],{icon:current})
    .addTo(mymap[id])
    .bindPopup("Lokasi terkini");
}

function getcenter2(id){
    var center = mymap[id].getCenter();   
    document.getElementById("bujur"+id+"").value = center.lng;
    document.getElementById("lintang"+id+"").value = center.lat;
}
