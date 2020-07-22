// MAPSS SAYA
var mymap;

$.getJSON("/center", function (data){
    mymap = L.map('mapid',{
        center :  [data.lintang,data.bujur],
        watch : true,
        zoom: 14,
        scrollWheelZoom: false,
    });
    L.geoJSON([prambanan]).addTo(mymap);
    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(mymap);
});

var layerGroup1 = L.layerGroup();
var layerGroup2 = L.layerGroup();

var popup = L.popup({
    closeButton: false
});

var objek = []; //OBJEK PETA
function show_objek() {
    $.getJSON("/objek", function (data) {
        for (var i = 0; i < data.length; i++) {
           var icon = L.icon({
               iconUrl: '/gambar/jenis/'+data[i].marker,
               iconSize:     [25, 25],
           });
           var name = data[i].nama;
           objek[i] = L.marker([data[i].lintang, data[i].bujur],{icon: icon}).addTo(mymap)
           .bindPopup(
               (info =
                   "<div class='cont'>"+
                       "<div class='box'>"+
                           "<div class='header'>"+
                               "<h5><strong>"+name+"</strong></h5>"+
                           "</div>"+
                           "<img src='/gambar/objek/thumbnail/"+data[i].foto1+"' alt='' width='100%' height='auto'>"+
                       "</div>"+
                   "</div>"
               )
           );
           layerGroup1.addLayer(objek[i]).addTo(mymap);
        }
   })
}
show_objek();

function hide(x) {
    if(x == 0){
        for (var i = 0; i < objek.length; i++){
            layerGroup1.removeLayer(objek[i])
        }
        $('#show')[0].attributes.onclick.nodeValue = "hide(1);";
        $('#show')[0].innerText = "Show Object";
    }
    else{
        show_objek();
        $('#show')[0].attributes.onclick.nodeValue = "hide(0);";
        $('#show')[0].innerText = "Clear Object";
    }
}

var kerusakan = [];//KERUSAKAN

function show_kr() {
    console.log("HOW");
    $.getJSON("/datapeta", function (data1) {
        for (var i = 0; i < kerusakan.length; i++){
            layerGroup2.removeLayer(kerusakan[i]);
        }
        for (var i = 0; i < data1.length; i++) {
            var icon = L.icon({
                iconUrl: '/gambar/jenis/'+data1[i].marker,
                iconSize:     [30, 30],
            });
            var name = data1[i].kerusakan;
            var status = data1[i].status;
            kerusakan[i] = L.marker([data1[i].lintang, data1[i].bujur],{icon: icon})
            .addTo(mymap)
            .bindPopup(
                (info =
                    "<div class='cont'>"
                        +"<div class='box'>"
                            +"<div class='header'>"
                                +"<h2><strong>"+name+"</strong></h2>"
                                +"<p>Desa : "+data1[i].desa+" </p>"
                                +"<p>RT/RW : "+data1[i].rt+"/"+data1[i].rw+" </p>"
                            +"</div>"
                            +"<img src='/gambar/kerusakan/thumbnail/"
                            +(status == 'Rencana' ? data1[i].foto1 : "")
                            +(status == 'Sedang' ? data1[i].foto2 : "")
                            +(status == 'Selesai' ? data1[i].foto3 : "")
                            +"' alt=''>"
                            +"<a id='jos' onclick='return show("+data1[i].id+");'>Detail<i class='fa fa-arrow-circle-right'></a>"
                            +"</a>"
                        +"</div>"
                    +"</div>"
                    )
            );
            layerGroup2.addLayer(kerusakan[i]).addTo(mymap);
        }
    })
}
show_kr();

$("select#desa").change(function(){
    var desa = $(this).children(":selected")[0].innerText;
    if(desa == "--Desa--"){
        show_kr();
    }
    else{
        $.getJSON("/datapeta", function (data1) {
            for (var i = 0; i < kerusakan.length; i++){
                layerGroup2.removeLayer(kerusakan[i]);
            }
            for (var i = 0; i < data1.length; i++) {
                var icon = L.icon({
                    iconUrl: '/gambar/jenis/'+data1[i].marker,
                    iconSize:     [30, 30],
                });
                if (desa == data1[i].desa) {
                    var name = data1[i].kerusakan;
                    console.log(name);
                    var status = data1[i].status;
                    kerusakan[i] = L.marker([data1[i].lintang, data1[i].bujur],{icon: icon})
                    .addTo(mymap)
                    .bindPopup(
                        (info =
                            "<div class='cont'>"
                                +"<div class='box'>"
                                    +"<div class='header'>"
                                        +"<h2><strong>"+name+"</strong></h2>"
                                        +"<p>Desa : "+data1[i].desa+" </p>"
                                        +"<p>RT/RW : "+data1[i].rt+"/"+data1[i].rw+" </p>"
                                    +"</div>"
                                    +"<img src='/gambar/kerusakan/thumbnail/"
                                    +(status == 'Rencana' ? data1[i].foto1 : "")
                                    +(status == 'Sedang' ? data1[i].foto2 : "")
                                    +(status == 'Selesai' ? data1[i].foto3 : "")
                                    +"' alt=''>"
                                    +"<a id='jos' onclick='return show("+data1[i].id+");'>Detail<i class='fa fa-arrow-circle-right'></a>"
                                    +"</a>"
                                +"</div>"
                            +"</div>"
                        )
                    );
                    layerGroup2.addLayer(kerusakan[i]).addTo(mymap);
                }
            }
        })
    }
});



// FOUND MY LOCATION
// function onLocationFound(e) {
//     var radius = e.accuracy / 2;

//     L.marker(e.latlng).addTo(mymap)
//         .bindPopup("Lokasi Anda ada didalam radius " + radius + "meter.").openPopup();
// }

// function onLocationError(e) {
//     alert(e.message);
// }

// mymap.on('locationfound', onLocationFound);
// mymap.on('locationerror', onLocationError);

// mymap.locate({setView: true});

// navigator.geolocation.getCurrentPosition(function(location) {
//     // latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
  
//     var mymap = L.map('mapid',{
//         center : latlng,
//         watch : true,
//         zoom: 13,
//         scrollWheelZoom: false,
//     })
//     L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
//     maxZoom: 20,
//     minZoom: 13,
//     subdomains:['mt0','mt1','mt2','mt3']
//     }).addTo(mymap);

//     L.geoJSON([bugisan]).addTo(mymap);

//     L.Routing.control({
//         waypoints: [
//           L.latLng(latlng.lat, latlng.lng),
//           L.latLng(-7.744464, 110.494553)
//         ]
//       }).addTo(mymap);   
  
//     var current = L.icon({
//         iconUrl: '/gambar/marker/current.png',
//         iconSize:     [17, 17], // Ukuran
//         iconAnchor:   [8, 13], // Posisi marker
//         popupAnchor:  [-13, -5], // Posisi Popup muncul
//         tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
//     });

//     var marker = L.marker(latlng,{icon:current}).addTo(mymap).bindPopup("Lokasi Anda");

// }); 

// var control = L.Routing.control({
//     router: L.routing.mapbox(LRM.apiToken),
//     plan: L.Routing.plan(waypoints, {
//         createMarker: function(i, wp) {
//             return L.marker(wp.latLng, {
//                 // draggable: true,
//                 icon: L.icon.glyph({ glyph: String.fromCharCode(65 + i) })
//             });
//         },
//         geocoder: L.Control.Geocoder.nominatim(),
//         routeWhileDragging: true
//     }),
//     routeWhileDragging: true,
//     routeDragTimeout: 250,
//     showAlternatives: true,
//     altLineOptions: {
//         styles: [
//             {color: 'black', opacity: 0.15, weight: 9},
//             {color: 'white', opacity: 0.8, weight: 6},
//             {color: 'blue', opacity: 0.5, weight: 2}
//         ]
//     }
// })
// .addTo(mymap)
// .on('routingerror', function(e) {
//     try {
//         map.getCenter();
//     } catch (e) {
//         map.fitBounds(L.latLngBounds(waypoints));
//     }

//     handleError(e);
// });

// L.Routing.errorControl(control).addTo(mymap);