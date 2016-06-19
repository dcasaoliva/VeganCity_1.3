<?php
/*
Template Name: Home VeganCity
*/
/**
*Home Page 
*Author: Carlos Ibañez
**/
 

get_header(); ?>

	<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

<div id="map"></div>
 

	<!---Consulta a Nominatim Reverse per extreure info adreça. No s'implementa per falta de dades en els serveis cartogràfics usats.
	$src_latlong= 'http://nominatim.openstreetmap.org/reverse?format=xml&lat='.$lat_lng[$i][1].'&lon='.$lat_lng[$i][2].'&zoom=18&addressdetails=1';	
	$xmlinfo = simplexml_load_file($src_latlong);
	array_push($info_adreça, $xmlinfo->addressparts->road.' '.$xmlinfo->addressparts->house_number.', '.$xmlinfo->addressparts->postcode);
	-->
		
	<div class="cerca_grid">
		<form action="" method="post" onsubmit="event.preventDefault(); ajaxDataToMarkers();">
			<div class="cerca_grid_a">
				<label for="cerca">Search by:</label>
				<input type="text" name="cerca" id="cerca" maxlength="25" value="" autocomplete="off"/>
			</div>
			<div class="cerca_grid_b">
				<span class="arrow_box">
				<button type="submit" id="butosearch" /><i class="fa fa-search fa-1x"></i></button>
				</span>
			</div>
		</form>
		<span class="removeSearch"></span>
		<span class="check_grid">
			<input id="checkName" name="cercaCheck" type="radio" checked="checked" onClick="validate()">
			<label class="labelCheck checkName" for="checkName">Name</label>
			<input id="checkCat" name="cercaCheck" type="radio" onClick="validate()">
			<label class="labelCheck checkCat" for="checkCat">Category</label>
		</span>
		<span id="empty-message"></span>
	</div>
	
	</main><!-- .site-main -->
	</div><!-- .content-area -->


<script type="text/javascript">
	
 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; //Protocol WP per la crida AJAX

	var autocomp = new Array();
	var autocomp2 = new Array();
	var availableTags =new Array();
	var availableAmbits = new Array();
		 
	jQuery('.removeSearch').click(function(){ //Borra la cerca efectuada per l'usuari per retornar de nou tots els resultats
	  jQuery('.removeSearch').css('display','none');
	  jQuery('#cerca').removeProp('disabled');
	  jQuery('#cerca').val('');
	  ajaxDataToMarkers();
	});
	  
	jQuery('#cerca').blur(function() { //Amaga l'avís 'sense coincidències' si l'usuari treu el focus de l'entrada de text
		jQuery('#empty-message').hide();
	});

	jQuery(document).ready( //Crida el Mapa i AJAX a 'mapeo-leaflet' i 'mapeo-ajax' mentre la pàgina es carrega
		creaMapa(),
		ajaxDataToMarkers_onLoad()
	); 
	
		search_byName = document.getElementById('checkName'); //Associem variables globals als botons de filtres
		search_byCategory = document.getElementById('checkCat');
			 
		function validate(){ //Autocomplete de jQuery UI segons el filtre indicat
			if (search_byName.checked){
				jQuery( "#cerca" ).autocomplete({
					source: availableTags,
					response: function(event, ui) {
            
					if (ui.content.length === 0) {
						jQuery("#empty-message").text("No matches found");
						jQuery("#empty-message").css("display", "inline");
					}
					else {
						jQuery("#empty-message").empty();
						jQuery("#empty-message").css("display", "none")
					}
					}
				});				
			} 
			else if (search_byCategory.checked){
				jQuery( "#cerca" ).autocomplete({
				  source: availableAmbits,
				  response: function(event, ui) {
           
					if (ui.content.length === 0) {
						jQuery("#empty-message").text("No matches found");
						jQuery("#empty-message").css("display", "inline");
						}
					else {
						jQuery("#empty-message").empty();
						jQuery("#empty-message").css("display", "none")
					}
				}
				});
			}	
		}
		
</script>

<?php 
get_footer(); ?>
