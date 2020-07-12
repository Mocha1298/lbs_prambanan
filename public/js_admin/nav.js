function show(nomor) {
  for (var index = 1; index <= 3; index++) {
    if(index != nomor){
      if ($('a#'+index+'.bagian').length) {
        $('a#'+index+'.bagian')[0].attributes.onclick.nodeValue = "return show("+index+");";
        $('#submenu'+index).fadeOut("slow"); 
      }
    }
    else{
      $('#submenu'+index).fadeIn("slow");
      $('a#'+index+'.bagian')[0].attributes.onclick.nodeValue = "return hide();";
    }
  }
}

function hide() {
  for (var index = 1; index <= 3; index++) {
    if ($('a#'+index+'.bagian').length) {
      $('#submenu'+index).fadeOut("slow"); 
      $('a#'+index+'.bagian')[0].attributes.onclick.nodeValue = "return show("+index+");";
    }
  }
}