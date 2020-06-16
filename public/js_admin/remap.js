// Inisialisasi LayerGroup
var marker = []
// Sampe sini
// KONDISI AWAL MARKER 

function load_ajax() {
    const ajax = new XMLHttpRequest();
    ajax.open("GET", "/datapeta", true);
    ajax.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            let data = JSON.parse(this.responseText);
            
            var i;

            for (i = 0; i < data.length; i++) {
                marker[i] = L.marker([data[i].lintang, data[i].bujur])
                .addTo(mymap)
                .bindTooltip(data[i].nama)
                .bindPopup(
                    (info =
                        "<div style='width:200px;'>"+
                            "<div class='small-box bg-white'>"+
                                "<div class='header text-center'>"+
                                    "<h5><strong>"+data[i].nama+"</strong></h5>"+
                                    "<p>RT/RW : "+data[i].rt+"/"+data[i].rw+" </p>"+
                                "</div>"+
                                // "<img src='/be_aset/dist/img/kerusakan/"+data[i].Foto2+"' alt='' width='100%' height='auto'>"+
                                // "<a href='/be/kerusakan/"+data[i].Id_Kerusakan+"' class='small-box-footer'>Detail Kerusakan <i class='fas fa-arrow-circle-right'></i>"+
                                "</a>"+
                            "</div>"+
                        "</div>"
                        )
                );
            }
        }
    };
    ajax.send();
}
load_ajax();

var popup = L.popup({
    closeButton: false
});//Inisialisasi POPUP LEAFLET

function onMapClick(e) {//FUNGSI ONCLICK
    popup.setLatLng(e.latlng);//POPUP MENGAMBIL KOORDINAT
}