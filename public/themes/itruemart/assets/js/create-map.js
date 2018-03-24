var secheltLoc = new google.maps.LatLng(49.47216, -123.76307);

var myMapOptions = {
    zoom: 18
    , center: secheltLoc
    , mapTypeId: google.maps.MapTypeId.ROADMAP
};
var theMap = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);


var marker = new google.maps.Marker({
    map: theMap,
    draggable: true,
    //13.76433,100.568127
    //position: new google.maps.LatLng(13.764504, 100.568311),
    position: new google.maps.LatLng(14.553221, 121.050677),
    visible: true
});

var contact = document.getElementById('c-addr-info').innerHTML;
var boxText = document.createElement("div");
boxText.innerHTML = '<h3>' + document.getElementById('business-name').innerHTML + '</h3>'
        + '<ul>'
        + '<li>' + document.getElementById('business-location').innerHTML + '</li>'
        + '<li>' + document.getElementById('business-tel').innerHTML + '</li>'
        + '<li>' + document.getElementById('business-mail').innerHTML + '</li>'
        + '<ul>';
;

var myOptions = {
    content: boxText
    , disableAutoPan: false
    , maxWidth: 0
    , pixelOffset: new google.maps.Size(-175, 0)
    , zIndex: null
    , boxStyle: {
        width: '350px'
    }
    , closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
    , infoBoxClearance: new google.maps.Size(1, 1)
    , isHidden: false
    , pane: "floatPane"
    , enableEventPropagation: false
};

google.maps.event.addListener(marker, "click", function(e) {
    ib.open(theMap, this);
});

var ib = new InfoBox(myOptions);

ib.open(theMap, marker);