// script disable backspace key It works on firefox and IE !!
if (typeof window.event == 'undefined'){
  document.onkeypress = function(e){
    var test_var=e.target.nodeName.toUpperCase();
    if (e.target.type) var test_type=e.target.type.toUpperCase();
    if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){
      return e.keyCode;
    }else if (e.keyCode == 8){
      e.preventDefault();
    }
  }
}else{
  document.onkeydown = function(){
    var test_var=event.srcElement.tagName.toUpperCase();
    if (event.srcElement.type) var test_type=event.srcElement.type.toUpperCase();
    if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){
      return event.keyCode;
    }else if (event.keyCode == 8){
      event.returnValue=false;
    }
  }
}
//////////////////////////////////////////////////////////


$(document).ready(function(){
  refreshFrame(1);
})

function link_file(file_link_value){
  window.location=file_link_value;
}

//fix iFrame is not show true height

/**
 * reScroll = 1 คือจะรีเฟรชเฟรมพร้อมกับเลื่อนแถบ rescroll ขึ้นด้านบน
 * reScroll = 0 คือจะรีเฟรชเฟรมเท่านั้น
 */
function refreshFrame(reScroll){
  if (typeof reScroll == "undefined") {
    reScroll = 1;
  }
  var theFrame = $("#link_file", parent.document.body);
  theFrame.height($(document.body).height() + 250);
  theFrame.width(890);
  if(reScroll==1){
    rescroll();
  }
}

// re window scroll to top window
function rescroll(){
  window.parent.scrollTo(0,0);
}