var ajaxRequest = function(){
  
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        return new ActiveXObject("Msxml2.XMLHTTP");
    }
    else {
         return false;
    }
}
