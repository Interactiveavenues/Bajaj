var VanillaRunOnDomReady = function() {
	
	
	
$("input[id*='location']").each(function() {
	var input = document.getElementById('location');
	var searchBox = new google.maps.places.SearchBox(this);

});
	
	
	
//var input = document.getElementById('location');
//var searchBox = new google.maps.places.SearchBox(input);
var markers = [];
var geocoder = new google.maps.Geocoder();



function initialize() {
    var options = {
     zoom : 3,
     center: new google.maps.LatLng(-33.8902, 151.1759),
     mapTypeId: google.maps.MapTypeId.TERRAIN
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), options);
}
google.maps.event.addDomListener(window, 'load', initialize);
}

var alreadyrunflag = 0;

if (document.addEventListener)
    document.addEventListener("DOMContentLoaded", function(){
        alreadyrunflag=1; 
        VanillaRunOnDomReady();
    }, false);
else if (document.all && !window.opera) {
    document.write('<script type="text/javascript" id="contentloadtag" defer="defer" src="javascript:void(0)"><\/script>');
    var contentloadtag = document.getElementById("contentloadtag")
    contentloadtag.onreadystatechange=function(){
        if (this.readyState=="complete"){
            alreadyrunflag=1;
            VanillaRunOnDomReady();
        }
    }
}

window.onload = function(){
  setTimeout("if (!alreadyrunflag){VanillaRunOnDomReady}", 0);
}