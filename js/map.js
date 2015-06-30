var infowindow = new google.maps.InfoWindow();
var mapmarker = new google.maps.MarkerImage('http://forunssetoriaiscnpc.com.br/wp-content/themes/forunssetoriaiscnpc/images/mapmarker.png', new google.maps.Size(37, 34) );
var shadow = new google.maps.MarkerImage('http://forunssetoriaiscnpc.com.br/wp-content/themes/forunssetoriaiscnpc/images/mapshadow.png', new google.maps.Size(37, 34) );

function initialize() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 4,
		center: new google.maps.LatLng(-15.780148,-47.92917),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	for (var i = 0; i < locations.length; i++) {
		var marker = new google.maps.Marker({
			position: locations[i].latlng,
			icon: mapmarker,
			shadow: shadow,
			map: map
		});
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(locations[i].info);
				infowindow.open(map, marker);
			}
		})(marker, i));
	}
}
