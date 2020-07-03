function show(nomor){
  for (var index = 1; index <= 3; index++) {
      document.getElementById('submenu'+nomor+'').style.display = 'block';
    if(index != nomor){
      document.getElementById('submenu'+index+'').style.display = 'none';        
    }      
  }
}
function hide(nomor){
    document.getElementById('submenu'+nomor+'').style.display = 'none';
}