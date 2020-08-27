var bujur = 0;
var lintang = 0;
var foto;
var current;
// layer
var layerGroup1 = L.layerGroup();
var layerGroup2 = L.layerGroup();
var layerLocate = L.layerGroup();
var marker_layer;
var ring_layer;
var control;//LRM
var status = 0;
var routing = 0;

// MYMAP

var geojsonLayer;
function map() {
    $.getJSON("/center/kecamatan/"+kec, function (data){
        mymap = L.map('mapid',{
            center :  [data.lintang,data.bujur],
            // watch : true,
            zoom: 14,
            // scrollWheelZoom: false,
            closePopupOnClick: false
        });
        geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data.batas,{
        fillOpacity : 0,
        color : 'white'
        }).addTo(mymap);
        L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            minZoom: 10,
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(mymap);
    });
}
map()

// LOad ICon USer

$.getJSON("/user", function (user){
    foto = user.photo;
    // MARKER CURRENT
    current = L.icon({
    iconUrl: "/gambar/user/"+foto,
    iconSize:     [50, 50], // Ukuran
    // iconAnchor:   [8, 13], // Posisi marker
    className: 'icon_current'
    });
});

var popup = L.popup({
    closeButton: false
});

// TAmpil OBjek

var objek = []; //OBJEK PETA
function show_objek() {
    $.getJSON("/objek", function (data0) {
        for (var i = 0; i < data0.length; i++) {
           var icon = L.icon({
               iconUrl: '/gambar/jenis/'+data0[i].marker,
               iconSize:     [30, 30],
           });
           var name = data0[i].nama;
           objek[i] = L.marker([data0[i].lintang, data0[i].bujur],{icon: icon})
           .bindTooltip(name).openTooltip()
           .bindPopup(
               (info =
                   "<div class='cont'>"+
                       "<div class='box'>"+
                           "<div class='header'>"+
                               "<h2><strong>"+name+"</strong></h2>"+
                           "</div>"+
                           "<img src='/gambar/objek/thumbnail/"+data0[i].foto1+"' alt='' width='100%' height='auto'>"+
                           "<a id='done' onclick='make_dst("+data0[i].lintang+","+data0[i].bujur+");'>Rute</a>"+
                       "</div>"+
                   "</div>"
               )
           ).addTo(mymap);
           layerGroup1.addLayer(objek[i]).addTo(mymap);
        }
   })
}
show_objek();

// HIde OBjek

function hide(x) {
    if(routing == 0 ){
        if(x == 0){
            for (var i = 0; i < objek.length; i++){
                layerGroup1.removeLayer(objek[i])
            }
            $('#show')[0].attributes.onclick.nodeValue = "hide(1);";
            $('#show')[0].innerHTML = "OBJEK <i class='fa fa-eye'></i>";
        }
        else{
            show_objek();
            $('#show')[0].attributes.onclick.nodeValue = "hide(0);";
            $('#show')[0].innerHTML = "OBJEK <i class='fa fa-eye-slash'></i>";
        }
    }
    else{
        alert("Intruksi dilarang saat sedang routing..")
    }
}

// TAmpil KErusakan

var kerusakan = [];//KERUSAKAN

function show_kr() {
    $.getJSON("/datapeta", function (data1) {
        for (var i = 0; i < kerusakan.length; i++){
            layerGroup2.removeLayer(kerusakan[i]);
        }
        $.getJSON("/center/kecamatan/"+kec, function (data){
            geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data.batas,{
            fillOpacity : 0,
            color : 'white'
            }).addTo(mymap);
        });
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
    var desa = $(this).children(":selected")[0].value;
    if(desa == "DESA"){
        geojsonLayer.remove()
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
                    var status = data1[i].status;
                    $.getJSON("/center/desa/"+desa, function (jos){
                        geojsonLayer.remove()
                        geojsonLayer = new L.GeoJSON.AJAX("/batas/"+jos.batas,{
                        fillOpacity : 0,
                        color : 'yellow'
                        }).addTo(mymap);
                    });
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


// TRack LOcation

function locateUser() {
    mymap.locate({
        // watch : false,
        setView : true,
        enableHighAccuracy:true
    });

	function onLocationFound(e) {
        var radius = e.accuracy / 2;

        if (marker_layer != null) {
            layerLocate.removeLayer(marker_layer);
            layerLocate.removeLayer(ring_layer);
        }

        marker_layer = L.marker(e.latlng,{icon:current}).addTo(mymap)
        .bindPopup("<h2>Anda disini!</h2>").openPopup();

        lintang = e.latitude;
        bujur = e.longitude;

        ring_layer = L.circle(e.latlng, radius).addTo(mymap);

        layerLocate.addLayer(marker_layer).addTo(mymap);
        layerLocate.addLayer(ring_layer).addTo(mymap);
        $('button.loc')[0].attributes.onclick.nodeValue = "relocate();";
        status = 1;
        console.log("SUCCESS TRACK LOCATION");
	}

	function onLocationError(e) {
		alert(e.message);
	}

	mymap.on('locationfound', onLocationFound);
    mymap.on('locationerror', onLocationError);
}

function relocate() {
    mymap.stopLocate();
    locateUser();
}

var route_a;
var route_b;

function make_dst(l,b) {
    if (status == 0) {
        alert("Lokasi tidak ditemukan, silahkan klik tombol cari lokasi terlebih dahulu..")
    }
    else{
        if(control != null){
            control.remove();
        }
        control = new L.Routing.control({
            createMarker: function() { return null; },
            waypoints: [
                L.latLng(lintang,bujur),
                L.latLng(l,b)
            ],
            routeDragTimeout: 250,
            draggableWaypoints: false,
			addWaypoints: false,
            // showAlternatives: true,
            altLineOptions: {
                styles: [
                    {color: 'black', opacity: 0.15, weight: 9},
                    {color: 'white', opacity: 0.8, weight: 6},
                    {color: 'blue', opacity: 0.5, weight: 2}
                ]
            }
        })
        .on('routingerror', function(e) {
            try {
                mymap.getCenter();
            } catch (e) {
                mymap.fitBounds(L.latLngBounds(control.getWaypoints().map(function(wp) { return wp.latLng; })));
            }       
            handleError(e);
        })
        .addTo(mymap);
        $('.routing').fadeIn("slow"); 
        routing = 1;
        route_a = l;
        route_b = b;
    }
}

function done() {
    mymap.removeControl(control);
    routing = 0;
    $('#done')[0].attributes.onclick.nodeValue = "make_dst("+route_a+","+route_b+");";
    $('.routing').fadeOut("slow"); 
}
function icon(){
    mymap.removeControl(control);
    routing = 0;
    $('.routing').fadeOut("slow"); 
    mymap.closePopup();
}