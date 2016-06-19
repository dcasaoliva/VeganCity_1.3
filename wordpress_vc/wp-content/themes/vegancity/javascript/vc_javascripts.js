/*General javascript functions for VeganCity*/

jQuery(document).ready(function() {
 
  jQuery("#cerca").keyup(function(event){
    if(event.keyCode == 13){
        ajaxDataToMarkers();
    }
});
 
 jQuery("#pass2").focusout(validatePass);
 

jQuery('#signup_form').submit(function() {
    if (jQuery.trim(jQuery("#email").val()) === "" || jQuery.trim(jQuery("#username").val()) === "" || 
		jQuery.trim(jQuery("#pass1").val()) === "" || jQuery.trim(jQuery("#pass2").val()) === "" || 
		jQuery.trim(jQuery("#birth").val()) === "" || jQuery.trim(jQuery("#city").val()) === "") {
        jQuery("#validate-status2").text("Es necesario rellenar todos los campos");
        return false;
    }
});

	
	//Effects for star rate system: change color and check input
	
	jQuery('.r_rating span .wpcf7-list-item').mouseover(function(){ 
		jQuery('.r_rating span .wpcf7-list-item').removeClass('stars-hover');
		jQuery(this).addClass('stars-hover');
		jQuery(this).prevAll().addClass('stars-hover');
	});
	
	jQuery('.r_rating span .wpcf7-list-item').mouseleave(function(){
		jQuery('.r_rating span .wpcf7-list-item').removeClass("stars-hover");	
	});
	
	jQuery('.r_rating span .wpcf7-list-item').click(function(){
		
		jQuery('.r_rating span .wpcf7-list-item').children("input:checkbox").prop('checked', false);
		jQuery('.r_rating span .wpcf7-list-item').removeClass('stars-selected');
		
		jQuery(this).children("input:checkbox").prop('checked', true);
		jQuery(this).addClass('stars-selected');
		jQuery(this).prevAll().addClass('stars-selected');
	});
	 
});

	


function validatePass() {
  var password1 = jQuery("#pass1").val();
  var password2 = jQuery("#pass2").val();
  var username = jQuery("#username").val();
  var birth = jQuery("#birth").val();
  var city = jQuery("#city").val();
  var email = jQuery("#email").val();

     if (password1.trim() === '') {
        jQuery("#validate-status").text("La contraseña no puede quedar vacía");  
    }
	else if(password1 != password2) {
        jQuery("#validate-status").text("Las contraseñas no coinciden");  
    } 
	else if (password1.trim().length < 6 || password2.length <6) {
		 jQuery("#validate-status").text("La contraseña debe tener un mínimo de 6 caracteres");
	}
	else{
	jQuery("#validate-status").text("");
	}
}

function ValidarPassword(){
 // Buscamos y guardamos los valores de los campos de contraseña
 var p1 = document.getElementById("pw").value;
 var p2 = document.getElementById("pw2").value;
 // Seteamos un par de variables de control.
 var espacios = false;
 var cont = 0;
 
 if (p1 != p2) { // Si las contraseñas no coinciden
   alert("Las contraseñas no coinciden.");
   return false; // No se ejecuta la validación
 } else if (p1.length == 0 || p2.length == 0) { // Si los campos de contraseña no contienen valores
       alert("Los campos de contraseña no pueden quedar vacios.");
       return false; // No se ejecuta la validación
     } else if (p1.length < 6 || p2.length < 6){ // Quiero que la contraseña tenga al menos 6 caracteres
           alert("Debes introducir una contraseña con un mínimo de 6 caracteres.");
           return false; // Si no se cumple, no se ejecuta la validación
         } else {
           // Vamos a comprobar que en los campos de contraseña no existan espacios
           // Podemos hacer esto mismo para el resto de campos si queremos
           while (!espacios && (cont < p1.length)){
             if (p1.charAt(cont) == " "){
               espacios = true; // Si hay un espacio, seteamos la variable a true
             }
             cont++;
           }
           if (espacios){ // Si la variable espacios es verdadera, hay espacios.
             alert("La contraseña no puede contener espacios en blanco.");
             return false; // No se ejecuta la validación
           } else {
             return true; // Si todo lo anterior está bien, dejamos que se valide el formulario. 
           }
        }
}

