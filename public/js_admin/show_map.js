var mymap;
var latlng;

mymap = L.map('mapid',{
    center :  [-7.720767501244917,110.48697531223296]
    ,
    watch : true,
    zoom: 13,
    scrollWheelZoom: false,
});

L.geoJSON([prambanan]).addTo(mymap);

L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
maxZoom: 20,
minZoom: 13,
subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);



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