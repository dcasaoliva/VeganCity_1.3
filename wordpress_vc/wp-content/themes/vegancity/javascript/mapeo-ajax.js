/*AJAX for map search filter*/		
	
	jQuery(window).load(function() { // Wait for window load
		jQuery(".se-pre-con").fadeOut("slow");;
	});
		
	function ajaxDataToMarkers_onLoad(){ //Funció exclusivament cridada quan es carrega la pàgina
		
	jQuery.ajax({
	url: ajaxurl,
    data: {
        'action':'data_onload',
		'cerca': jQuery('#cerca').val()
		},
	dataType: "json",
    success:function(data) {  //Resultat de la crida a la BBDD
			
				newmarkers.clearLayers(); //Netegem el grup de marcadors
		
				for(var i=0;i<data.length;i++){
				
				
					autocomp.push(data[i].name); //Prepara autocompletat NOMS
					
					var temp = new Array; //Prepara autocompletat AMBITS
					temp = (data[i].categories).split(",");
					for (var z=0; z<temp.length; z++){
						if (jQuery.inArray(temp[z], autocomp2) == -1){
							autocomp2.push(temp[z]);
							}
					}
	
	
					var newmarker = L.marker([data[i].coord[1], data[i].coord[2]], {icon: redIcon});
	newmarker.bindPopup("<span class='negreta'>"+ data[i].name +"</span>"+data[i].stars_rated+"<br>"+ data[i].street +" "+ data[i].snumber +"<br>"+ data[i].phone +"<br>"+"Category: "+ data[i].categories+"<br><a href='"+ data[i].link +"'>Go to the page</a>");
	
					newmarkers.addLayer(newmarker);
						}
						
						
				map.addLayer(newmarkers); //Mostrem el nou grup de marcadors
		
				availableTags = autocomp; //Llista definitiva Autocompletat NOMS
				availableAmbits=autocomp2; //Llista definitiva Autocompletat AMBITS
				
				jQuery( "#cerca" ).autocomplete({
				  source: availableTags,
				  response: function(event, ui) { //Mostra avís quan no hi han coincidències amb la cerca
						if (ui.content.length === 0) {
							jQuery("#empty-message").text("No matches found");
							jQuery("#empty-message").css("display", "inline");
						} else {
							jQuery("#empty-message").empty();
							jQuery("#empty-message").css("display", "none")
						}
					}
				});
						
		},
		
		 error: function(errorThrown){
            console.log(errorThrown);
			}
		});	
	}
	
		
	function ajaxDataToMarkers(){ //Funció que es crida cada cop que l'usuari fa una cerca
		
		if (search_byName.checked){ //Obtenim el filtre de la cerca NOM o AMBIT
			var ajax_action = 'data_onload';
			} 
		else if (search_byCategory.checked){
			var ajax_action = 'data_category';
		}
		
		jQuery.ajax({
			url: ajaxurl,
			data: {
				'action': ajax_action,
				'cerca': jQuery('#cerca').val()
			},
			
			dataType: "json",
			success:function(data) {  //Resultat de la crida a la BBDD
			
			newmarkers.clearLayers(); //Repetim operacions pels nous resultats
		
				for(var i=0;i<data.length;i++){
				
			
				var newmarker = L.marker([data[i].coord[1], data[i].coord[2]], {icon: redIcon});
	newmarker.bindPopup("<span class='negreta'>"+ data[i].name +"</span>"+data[i].stars_rated+"<br>"+ data[i].street +" "+ data[i].snumber +"<br>"+ data[i].phone +"<br>"+"Category: "+ data[i].categories +"<br><a href='"+ data[i].link +"'>Go to the page</a>");
	
				newmarkers.addLayer(newmarker);
				}
						
				map.addLayer(newmarkers);
							
				if (jQuery('#cerca').val()!=''){ //Mostra el botó per desfer la cerca efectuada per l'usuari
					jQuery('.removeSearch').css('display', 'block');
					jQuery('#cerca').prop('disabled', 'true');
				}	
			},
			
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});	
	}

		
		