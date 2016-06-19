/*
Script para la creación del mapa. Basado en Leaflet: www.leafletjs.com
*/

function creaMapa(){

	map = L.map('map').setView([41.38991109178002, 2.171964902496338], 14); //Crea el mapa y establece la ubicación inicial

	
		L.tileLayer('http://otile1.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.jpg', { //Call map's tiles
							maxZoom: 18,
							zoomControl: true,
							attribution: 'Thanks to <a href=\"http://openstreetmap.org\">OpenStreetMap</a> & <a href=\"http://mapquest.com\">Mapquest</a>, ' +  '<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>'
					}).addTo(map);
		map.zoomControl.setPosition('topright');
										
			redIcon = L.icon({ //Configuración del marcador
			iconUrl: 'http://vegancity.esy.es/wp-content/themes/vegancity/images/marker-icon.png',
			iconRetinaUrl: 'http://vegancity.esy.es/wp-content/themes/vegancity/images/marker-icon-2x.png',
			shadowUrl: 'http://vegancity.esy.es/wp-content/themes/vegancity/images/marker-shadow.png',
			iconSize:     [32, 52], // size of the icon
			shadowSize:   [50, 55], // size of the shadow
			iconAnchor:   [16, 52], // point of the icon which will correspond to marker's location
			shadowAnchor: [15, 55],  // the same for the shadow
			popupAnchor:  [1, -50] // point from which the popup should open relative to the iconAnchor
		});	
		
		newmarkers = new L.FeatureGroup(); //Crea un grupo de marcadores que nos permite controlarlos a la vez
		
}