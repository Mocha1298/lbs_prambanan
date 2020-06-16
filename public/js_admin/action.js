$(document).ready(function(){
  $('tr.table').contextmenu(function(e){
    var index = $('div#contextMenu'); 
    for(var i = 0 ; i < index.length ; i++){
      index.eq(i).css({
        display: "none"
      });
    }
    var id;
    id  = $(this).attr('id');
    contextMenu = $("div#contextMenu.cm_"+id+"");
    contextMenu.css({
      display: "block",
      left: e.pageX,
      top: e.pageY
    });
    return false;
  });
  $(document).click(function(){
    contextMenu.css({
      display: "none"
    });
  }); 
});