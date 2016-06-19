
<?php
/** Código para recibir la dirección exacta en función de las coordenadas marcadas en el mapa. En desuso por falta de exactitud en los datos recibidos, pero podría ser interesante para obtener la ciudad de cada marcador, en caso de ampliar la web a más ciudades.


if(function_exists($_GET['f'])) { // get function name and parameter  
$_GET['f']($_GET["p"]);
} else {
echo 'Method Not Exist';
}

function filtreConsulta(p){      // create php function here  
echo p ;
 
 } 
$src_latlong= 'http://nominatim.openstreetmap.org/reverse?format=xml&lat='.$lat_lng[0].'&lon='.$lat_lng[1].'&zoom=18&addressdetails=1';	
	$xmlinfo = simplexml_load_file($src_latlong);
	array_push($info_adreça, $xmlinfo->addressparts->road.' '.$xmlinfo->addressparts->house_number.', '.$xmlinfo->addressparts->postcode);
	echo $info_adreça;
	
	**/
?> 