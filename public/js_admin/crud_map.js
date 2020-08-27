var classname = $('tr.table');
var id = '';
var mymap = [];
var mymup = [];

// Input data
var mymap1

if(input == "kecamatan"){
    // INPUT
    mymap1 = L.map('mapid',{
        center :  [-7.7520153,110.4892787],
        zoom: 13,
    });
    L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        minZoom: 13,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(mymap1);
    // EDIT
    var mymap = [];
    for (let i = 0; i < classname.length; i++) {
      id = $(classname[i]).attr('id');
      $.getJSON("/center/kecamatan/"+id+"", function (data){
          mymap[id] = L.map("mapid"+id, {
              center: [data.lintang,data.bujur],
              zoom: 20,
              // scrollWheelZoom: false,
          });
          var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data.batas,{
              fillOpacity : 0,
              color : 'white'
          });
          geojsonLayer.addTo(mymap[id]);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
              maxZoom: 20,
              minZoom: 12,
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
          L.marker([data.lintang,data.bujur],{icon:current})
          .addTo(mymap[id])
          .bindPopup("Lokasi terkini");
      })
    }
}

function getcenter1(){
    var center = mymap1.getCenter();
    
    document.getElementById("bujur").value = center.lng;
    document.getElementById("lintang").value = center.lat;
}


// EDIT DATA

function getcenter2(id){
    var center = mymap[id].getCenter();   
    document.getElementById("bujur"+id).value = center.lng;
    document.getElementById("lintang"+id).value = center.lat;
}
