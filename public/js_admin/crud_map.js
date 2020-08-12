var classname = $('tr.table');
var id = '';
var mymap = [];

var old_b = $("#bujur").value;
var old_l = $("#lintang").value;

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
          L.marker([data.lintang,data.bujur],{icon:current})
          .addTo(mymap[id])
          .bindPopup("Lokasi terkini");
      })
    }
}
else if(input == "desa"){
    $.getJSON("/center/kecamatan/"+desa, function (data0){
        mymap1 = L.map('mapid',{
            center :  [data0.lintang,data0.bujur],
            zoom: 13,
        });
        var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data0.batas,{
            fillOpacity : 0,
            color : 'white'
        });    
        geojsonLayer.addTo(mymap1);
        L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            minZoom: 13,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(mymap1);
    });
    // EDIT
    for (let i = 0; i < classname.length; i++) {
        id = $(classname[i]).attr('id');
        var url = "/center/desa/"+id;
        var data = [];
        $.getJSON(url, function (data1){
            var map = "mapid"+data1.id;
            mymap[id] = L.map(map, {
                center: [data1.lintang,data1.bujur],
                zoom: 20,
                // scrollWheelZoom: false,
            });
            var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data1.batas,{
                fillOpacity : 0,
                color : 'white'
            });
            geojsonLayer.addTo(mymap[id]);
            L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
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
            L.marker([data1.lintang,data1.bujur],{icon:current})
            .addTo(mymap[id])
            .bindPopup("Lokasi terkini");
        })
    }
}
else{
    $.getJSON("/center/desa/"+desa, function (data2){
        mymap1 = L.map('mapid',{
            center :  [data2.lintang,data2.bujur],
            zoom: 13,
        });
        var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data2.batas,{
            fillOpacity : 0,
            color : 'white'
        });    
        geojsonLayer.addTo(mymap1);
        L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            minZoom: 13,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(mymap1);
    });
    // EDIT
    for (let i = 0; i < classname.length; i++) {
        id = $(classname[i]).attr('id');
        $.getJSON("/center/desa/"+id+"", function (data3){
            mymap[id] = L.map("mapid"+id, {
                center: [data3.lintang,data3.bujur],
                zoom: 20,
                // scrollWheelZoom: false,
            });
            var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data3.batas,{
                fillOpacity : 0,
                color : 'white'
            });
            geojsonLayer.addTo(mymap[id]);
            L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
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
            L.marker([data3.lintang,data3.bujur],{icon:current})
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
