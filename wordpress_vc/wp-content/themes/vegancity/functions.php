<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
wp_enqueue_style( 'leaflet-css', get_stylesheet_directory_uri().'/leaflet/leaflet.css' );
wp_register_style ('googlefont-opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800italic,800)', array());
wp_register_style ('googlefont-muli', 'https://fonts.googleapis.com/css?family=Muli', array());
wp_register_style ('googlefont-comfortaa', 'http://fonts.googleapis.com/css?family=Comfortaa', array());
wp_register_style ('fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array());

wp_enqueue_style( 'auth-style', get_stylesheet_directory_uri().'/css/ajax-auth-style.css' );


wp_enqueue_style( 'googlefont-muli');	
wp_enqueue_style( 'googlefont-comfortaa');
wp_enqueue_style( 'fontawesome');
} 


function enqueue_js() {
	      if (!is_admin()) {
		wp_deregister_script('jquery');// Unregister default jQuery script because we want it in footer
		wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', '', '', true);
		wp_register_script( 'jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', '', '', true);

	
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script( 'javascript', get_stylesheet_directory_uri() . '/javascript/vc_javascripts.js', array('jquery'), true );
		
		wp_enqueue_script( 'leaflet', get_stylesheet_directory_uri() . '/leaflet/leaflet-src.js', array(), true );
		wp_enqueue_script('mapeo-leaflet', get_stylesheet_directory_uri() . '/javascript/mapeo-leaflet.js', array('jquery'), true);
		wp_enqueue_script('mapeo-ajax', get_stylesheet_directory_uri() . '/javascript/mapeo-ajax.js', array('jquery'), true);


		}
	}
add_action('wp_enqueue_scripts', 'enqueue_js');



 /*Add bootstrap support to the Wordpress theme
function theme_add_bootstrap() {
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'style-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_add_bootstrap' );*/



add_filter('redirect_canonical','pif_disable_redirect_canonical');

function pif_disable_redirect_canonical($redirect_url) {
if (is_singular()) {
	$redirect_url = false;
}
return $redirect_url;
}


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
show_admin_bar(false);
}
}

require_once( get_stylesheet_directory() . '/libs/custom-ajax-auth.php' ); //Call to AJAX Signup-Login code

add_action( 'init', 'blockusers_init' );

function blockusers_init() { //Evitamos que usuarios sin permisos de administración usen el acceso wp-admin
    if ( is_admin() && ! current_user_can( 'administrator' ) && 
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 ); //Adding Singup & Login buttons to menu
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a href="'. wp_logout_url(home_url()) .'">Log Out</a></li>';
		    	
    }
    else if (!is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a class="login_button" id="show_login" href="">Log In</a></li>';
		
        $items .= '<li><a class="login_button" id="show_signup" href="">Sign up</a></li>';

    }
    return $items;
}



function create_posttype() {//Create Post type

	register_post_type( 'Rates',
		array(
			'labels' => array(
				'name' => __( 'Rates' ),
				'singular_name' => __( 'Rate' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'rates'),
			'menu_position' => 5, // places menu item directly below Posts
			'menu_icon' => 'dashicons-star-filled',
		)
	);
}
add_action( 'init', 'create_posttype' );



function data_onload(){ //AJAX CALL by NAME
	global $wpdb;
	
	$wpdb->show_errors();
	$data_onload = array();
	unset($data_onload);

	if ( isset($_REQUEST) ) {
     
	$cerca_nom = '%' . $wpdb->esc_like ($_REQUEST['cerca']) . '%';		
	$data_onload = $wpdb->get_results($wpdb->prepare("SELECT id, Name, Coord, Street, sNumber, Email, Phone, Url, Facebook, Twitter, OtherSM, Categories, Wp_link FROM `vc_places` WHERE Name LIKE %s AND Status='publish'", $cerca_nom));
	
	if ($data_onload){
	$data_marker= array();

	foreach ($data_onload as $data_load){

	$data_marker[]=array(
	id => $data_load->id,
	name => $data_load->Name,
	coord => multiexplode(array(",",";"),$data_load->Coord),
	street => $data_load->Street,
	snumber => $data_load->sNumber,
	email => $data_load->Email,
	phone => $data_load->Phone,
	url => $data_load->Url,
	facebook => $data_load->Facebook,
	twitter => $data_load->Twitter,
	othersm => $data_load->OtherSM,
	categories => $data_load->Categories,
	stars_rated => show_stars($data_load->id),
	link => $data_load->Wp_link,
	);
	
}echo json_encode($data_marker);

}else{
echo "There is no data";
}	
}
die();
}

add_action( 'wp_ajax_data_onload', 'data_onload' ); 
add_action( 'wp_ajax_nopriv_data_onload', 'data_onload' );


function data_category(){ //AJAX CALL by CATEGORY
	global $wpdb;
	
	$wpdb->show_errors();
	$data_onload = array();
	unset($data_onload);

	
	if ( isset($_REQUEST) ) {
     
	$cerca = '%' . $wpdb->esc_like ($_REQUEST['cerca']) . '%';		
	$data_onload = $wpdb->get_results($wpdb->prepare("SELECT id, Name, Coord, Street, sNumber, Email, Phone, Url, Facebook, Twitter, OtherSM, Categories, Wp_link FROM `vc_places` WHERE Categories LIKE %s AND Status='publish'", $cerca));
	
	if ($data_onload){
	$data_marker_category= array();
	

	foreach ($data_onload as $data_load){

	$data_marker_category[]=array(
	id => $data_load->id,
	name => $data_load->Name,
	coord => multiexplode(array(",",";"),$data_load->Coord),
	street => $data_load->Street,
	snumber => $data_load->sNumber,
	email => $data_load->Email,
	phone => $data_load->Phone,
	url => $data_load->Url,
	facebook => $data_load->Facebook,
	twitter => $data_load->Twitter,
	othersm => $data_load->OtherSM,
	categories => $data_load->Categories,
	stars_rated => show_stars($data_load->id),
	link => $data_load->Wp_link,
	);
	

}echo json_encode($data_marker_category);

}else{
echo "There is no data";
}	
}
die();
}

add_action( 'wp_ajax_data_category', 'data_category' ); 
add_action( 'wp_ajax_nopriv_data_category', 'data_category' );

  /**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/include/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

 
  //Register the required plugins for this theme. 
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'      => 'Leaflet Map for VeganCity',
            'slug'      => 'leaflet-map-for-vegancity',
			'source'    => get_stylesheet_directory() . '/plugins/leaflet-map-for-vegancity.zip', 
            'required'  => true,
			),
		array(
			'name'    => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
		array(
			'name'    => 'Contact Form 7 - Dynamic Text Extension',
            'slug'      => 'contact-form-7-dynamic-text-extension',
            'required'  => true,
        ),
		array(
			'name'    => 'CF7 Map Field for VeganCity',
            'slug'      => 'cf7-map-field-for-vegancity',
			'source'    => get_stylesheet_directory() . '/plugins/cf7-map-field-for-vegancity.zip', 
            'required'  => true,
        ),

    );

    
     //Array of configuration settings for Required Plugins. 
    
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}




function form_to_post($wpcf7){//Create a new 'Draft' Post with data form on submit, and save data on database. Conditionals for Places and Ratings.
	
	$id_cf7 = $wpcf7->id();
	if ( $id_cf7=='15'){//Contact form ID number for PLACES
	
	
		/*** Drawing up received data ***/
	
		$concat_categories = implode (', ',$_POST['CATEGORIES']); //Concat CATEGORIES, post_content wait for a string.
		
		if (!empty($_POST['EMAIL'])){
			
			$place_email = "<br><span class='negreta'>Email: </span>".$_POST['EMAIL'];
			
		} else {$place_email = "";}
		
		if (!empty($_POST['URL']) OR !empty($_POST['FACEBOOK']) OR !empty($_POST['TWITTER']) OR !empty($_POST['OTHERSM'])){
		
			$internet_title = "<br><span class='negreta'>Internet: </span>";
			
		}  else {
				
			$internet_title ="";
			
			}
		
				
			if (!empty($_POST['URL'])){
			$url = "<br><a target='_blank' href=".$_POST['URL'].">".($_POST['URL'])."<i class='fa fa-external-link'></i></a>";
			} else {$url= "";}
				
			if (!empty($_POST['FACEBOOK'])){
			$facebook = "<br><a target='_blank' href=".$_POST['FACEBOOK'].">".($_POST['FACEBOOK'])."<i class='fa fa-external-link'></i></a>";
			} else {$facebook="";}
				
			if (!empty($_POST['TWITTER'])){
			$twitter = "<br><a target='_blank' href=".$_POST['TWITTER'].">".($_POST['TWITTER'])."<i class='fa fa-external-link'></i></a>";
			} else {$twitter="";}
				
			if (!empty($_POST['OTHERSM'])){
			$other = "<br><a target='_blank' href=".$_POST['OTHERSM'].">".($_POST['OTHERSM'])."<i class='fa fa-external-link'></i></a>";
			} else {$other="";}
			
		
						
			
		if(!empty($_POST['PHONE'])){
			$phone = "<br><span class='negreta'>Phone: </span>".($_POST['PHONE']);
			} else {$phone = "";}
					
	 
	
		$post_title     = $_POST['NAME'];
		$post_content	= "<br><span class='negreta'>Adress: </span>".$_POST['STREET']." ".$_POST['SNUMBER'].$phone.$place_email.$internet_title.$url.$facebook.$twitter.$other."<br><span class='negreta'>Category: </span>".$concat_categories;

		$tags			= $_POST['CATEGORIES'];
		$user_ID = get_current_user_id();
		
		/*
	Advice for myself: $wpcf7->posted_data is deprecated, we use get_posted_data() instead.
	*/
   
		$submission = WPCF7_Submission::get_instance();  //Default data call for Contact Form7 v.4.4.2
		$submited['posted_data'] = $submission->get_posted_data();
		$uploaded_files = $submission->uploaded_files(); 
		
$image_name = $submited['posted_data']['file-field']; //get file name

	$content = file_get_contents($uploaded_files['file-field']); //get url temporary folder
	
	$upload = wp_upload_bits( $image_name, '', $content); //uploading copy with predeterminate wp function

	$final_route = $upload['url']; //get our new image path

	$filename= $upload['file']; //get our new image name, just in case the original one was already used
	
	
	list($upload_width, $upload_height) = getimagesize($filename);
	
    if ($upload_width<800){
		  var_dump ('size error'); 
		die();
		
	}
	
	$places_cat= get_category_by_slug('places');
	$places_cat_id = $places_cat->term_id;
		
		global $error_array;
		$error_array = array();
 
		if (empty($post_title)) $error_array[]='Please add a title.';
		if (empty($post_content)) $error_array[]='Please add some content.';
 
		if (count($error_array) == 0){

	


 	/*** INSERT DATA AS A POST ON VC_POSTS ***/
			$post_id = wp_insert_post( array( 
				'post_author'	=> $user_ID,
				'post_title'	=> $post_title,
				'post_type'     => 'post',
				'post_content'	=> $post_content,
				'tags_input'	=> $tags,
				'post_category' => array($places_cat_id),
				'post_status'	=> 'draft'
				) );	

	/*** CF7 saves uploaded images in a temporary folder, sends it and removes it. Here we get temporary url file in order to make a copy to our media library upload folder. Finally we attach the image to the post we just created. ***/
	
	
   
	


	require_once(ABSPATH . 'wp-admin/includes/admin.php'); 

	  $wp_filetype = wp_check_filetype(basename($filename), null );

		$attachment = array( //prepare uploaded image required info by default wp function wp_insert_attachment 

		 'post_mime_type' => $wp_filetype['type'],

		 'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),

		 'post_content' => '',

		 'post_status' => 'inherit'

	  );

	 

  $attach_id = wp_insert_attachment( $attachment, $final_route, $post_id); //attach uploaded image to our post


  require_once(ABSPATH . 'wp-admin/includes/image.php');

  $attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); //getting image related metadata

  wp_update_attachment_metadata( $attach_id, $attach_data ); //adding image related metadata

  update_post_meta($post_id, "_thumbnail_id", $attach_id); //ask for thumbnail option

  

		//add_post_meta($post_id, 'customfield1', $submited['posted_data']['customfield1']);

		//add_post_meta($post_id, 'customfield2', $submited['posted_data']['customfield2']);
	
				
 
	
	
   		/*** INSERT DATA AS DATA ON VC_PLACES***/

   
	
   global $wpdb;

   $submission = WPCF7_Submission::get_instance();
 
   if ( $submission ) {
 
       $submited = array();
       $submited['title'] = $wpcf7->title();
       $submited['posted_data'] = stripslashes_deep($submission->get_posted_data());

    }
	
	
	
     $wpdb->insert($wpdb->prefix . 'places', 
		    array( 
						  'id' => $post_id,
                          'form'  => $submited['title'], 
						  "name"   =>  sanitize_text_field($submited['posted_data']['NAME']),
						  'coord'   => sanitize_text_field($submited['posted_data']['COORD']),
						  'street'   => sanitize_text_field($submited['posted_data']['STREET']),
						  'snumber'   => $submited['posted_data']['SNUMBER'],
						  'email'   => sanitize_email($submited['posted_data']['EMAIL']),
						  'phone'   => sanitize_text_field($submited['posted_data']['PHONE']),
						  'url'   => sanitize_text_field($submited['posted_data']['URL']),
						  'facebook'   => sanitize_text_field($submited['posted_data']['FACEBOOK']),
						  'twitter'   => sanitize_text_field($submited['posted_data']['TWITTER']),
						  'othersm'   => sanitize_text_field($submited['posted_data']['OTHERSM']),
						  'categories'   => implode (',', $submited['posted_data']['CATEGORIES']),
						  'user_ID'   => $user_ID,
						  'date' => date('Y-m-d H:i:s')
			   )
		);
		$wpdb->show_errors();
		} else {
			
		}

	} else if ( $id_cf7=='22'){ //Contact form ID number for RATES
			
			
			/*** Drawing up received data ***/
			global $wpdb;
			
			$user_ID = get_current_user_id();
			$place_ID = $_POST['r_postid'];

			$user_name = $wpdb->get_var( $wpdb->prepare( "SELECT display_name FROM $wpdb->users WHERE id = %s ", $user_ID ) );
			
			$place_name = $wpdb->get_var( $wpdb->prepare( "SELECT name FROM vc_places WHERE id = %s ", $place_ID ) );
			
			
			
			if(!empty($user_name)){
				
				$userSaid = "<span class='user-said'><span class='negreta'>".$user_name."</span> said:</span>";
			} else {$userSaid = "";}
			 
			if(!empty($_POST['r_best'])){
			$rBest = "<br><br><span class='destacat-verd'>Best: </span><br>".sanitize_text_field($_POST['r_best']);
			} else {$rBest = "";}
			
			if(!empty($_POST['r_notbest'])){
			$rNotbest = "<br><br><span class='destacat-lila'>Not best: </span><br>".sanitize_text_field($_POST['r_notbest']);
			} else {$rNotbest = "";}
			
			if(!empty($_POST['r_rating'])){
			$rStar = $_POST['r_rating'];
			} else {$rStar = "";}
						
	
		$post_title     = $user_name." rate ".$place_name." with ".$rStar."star";
		$post_content	= $userSaid.$rBest.$rNotbest;
		
		global $error_array;
		$error_array = array();
 
		if (empty($post_title)) $error_array[]='Please add a title.';
		if (empty($post_content)) $error_array[]='Please add some content.';
 
		if (count($error_array) == 0){
 
 		/*** INSERT DATA AS A POST ON VC_POSTS***/

			$post_id = wp_insert_post( array(
				'post_author'	=> $user_ID,
				'post_title'	=> $post_title,
				'post_type'     => 'rates',
				'post_content'	=> $post_content,
				'post_status'	=> 'draft',
				'post_parent'   => $_POST['r_postid']
				) );			
			
			
			/*** INSERT DATA AS DATA ON VC_RATING***/

			global $wpdb;
			
			 $submission = WPCF7_Submission::get_instance();
 
   if ( $submission ) {
 
       $submited = array();
       $submited['title'] = $wpcf7->title();
       $submited['posted_data'] = stripslashes_deep($submission->get_posted_data());
		//var_dump( $submited['posted_data']['r_rating'] );
    }
	

     $wpdb->insert($wpdb->prefix . 'rating', 
		    array( 
							'id' => $post_id,
                          'r_best' => sanitize_text_field($submited['posted_data']['r_best']),
						  'r_notbest' => sanitize_text_field($submited['posted_data']['r_notbest']),
						  'r_star' => $_POST['r_rating'],
						 'place_id' => $_POST['r_postid'],
						  'user_id' => $user_ID,
						  'r_date' => date('Y-m-d H:i:s')
			   )
		);
	
		$wpdb->show_errors();
		} else {
			
		}
	
	}
}

remove_all_filters ('wpcf7_before_send_mail'); 
 
add_action('wpcf7_before_send_mail','form_to_post');


 function get_page_by_post_name($post_name, $output = OBJECT, $post_type = 'post'){   
 global $wpdb;
 $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status='publish'", $post_name, $post_type ) );

 return get_post($page, $output);
 
 }
 add_action('init','get_page_by_post_name');
 

function change_status_database($postID) //Change Status to Published on database when the post is published. Just for regular posts, post_type==POSTS
{
   global $wpdb;  
  
   $post_url= get_permalink($postID); 
   
  $wpdb->update('vc_places',array('status'=>'publish', 'Wp_link'=>$post_url), array ('id'=>$postID)); 

}
function change_custom_status_database($postID) 
/*Change Status to Published on database when the post is published. Just for custom posts, post_type==RATES. In addition, we add the new vote from published RATE to the related PLACE*/
{
   global $wpdb;  
	
	$wpdb->update('vc_rating',array('r_status'=>'publish'), array ('id'=>$postID));
	
	$starsToInsert = $wpdb->get_var($wpdb->prepare("SELECT r_star FROM vc_rating WHERE id = %s", $postID));
	
	$placeIdRated = $wpdb->get_var($wpdb->prepare("SELECT place_id FROM vc_rating WHERE id = %s", $postID));
	
	$starsCounter = $wpdb->get_var($wpdb->prepare("SELECT Total_stars FROM vc_places WHERE id = %s", $placeIdRated));
	
	$votesCounter = $wpdb->get_var($wpdb->prepare("SELECT votes FROM vc_places WHERE id = %s", $placeIdRated));
	
	$newVotesCounter = $votesCounter+1;
	
	$newTotal =($starsCounter + $starsToInsert);
	
	$newRate = ($newTotal / $newVotesCounter);
	
	$wpdb->update('vc_places',array('stars'=>$newRate, 'total_stars'=>$newTotal, 'votes'=>$newVotesCounter), array ('id'=>$placeIdRated));

}
add_action( 'publish_post', 'change_status_database' );
add_action( 'publish_rates', 'change_custom_status_database');

function post_unpublished( $new_status, $old_status, $post ) { 
/*Change Status to Draft on database when post is unpublished. Same call works for regular and custom posts. In addition, for post_type = RATES, we remove this vote from related PLACE.*/

    	global $wpdb;
 
	if ( 'post' == $post->post_type && $old_status == 'publish'  &&  $new_status != 'publish' ) {
		
	$post_id= $post->ID;
	$wpdb->update('vc_places',array('status'=>'draft'), array ('id'=>$post_id)); 
    }
	
	else if ( 'rates' == $post->post_type && $old_status == 'publish'  &&  $new_status != 'publish' ) {
		
	$post_id= $post->ID;
		
	$starsToRemove = $wpdb->get_var($wpdb->prepare("SELECT r_star FROM vc_rating WHERE id = %s", $post_id));
	
	$placeIdRated = $wpdb->get_var($wpdb->prepare("SELECT place_id FROM vc_rating WHERE id = %s", $post_id));
	
	$starsCounter = $wpdb->get_var($wpdb->prepare("SELECT total_stars FROM vc_places WHERE id = %s", $placeIdRated));
	
	$votesCounter = $wpdb->get_var($wpdb->prepare("SELECT votes FROM vc_places WHERE id = %s", $placeIdRated));
	
	$newVotesCounter = $votesCounter-1;
	
	$newTotal =($starsCounter - $starsToRemove);
	
	$newRate =($newTotal / $newVotesCounter);
	
	$wpdb->update('vc_places',array('stars'=>$newRate, 'total_stars'=>$newTotal, 'votes'=>$newVotesCounter), array ('id'=>$placeIdRated));
	
	$wpdb->update('vc_rating',array('r_status'=>'draft'), array ('id'=>$post_id)); 

    }
}
add_action( 'transition_post_status', 'post_unpublished', 10, 3 );

function post_deleted( $new_status, $old_status, $post ) { //Delete row on database when post is deleted. Same call works for regular and custom posts. Please note 'restore' options will not work on VeganCity.

    	global $wpdb;

	if ( $post->post_type == 'post'  && $new_status == 'trash' ) {
			
	$post_id= $post->ID;
	$wpdb->delete('vc_places', array ('id'=>$post_id)); 
	
	$media = get_children(array(  //Delete associated image too
			'post_parent' => $post_id,
			'post_type' => 'attachment'
		));

		foreach ($media as $file) {
		   
			wp_delete_attachment($file->ID);
			unlink(get_attached_file($file->ID));
		}
	
	}
	
	else if ( $post->post_type == 'rates' && $new_status == 'trash' ) {
			
	$post_id= $post->ID;
	$wpdb->delete('vc_rating', array ('id'=>$post_id)); 
    }

}

add_action( 'transition_post_status', 'post_deleted', 10, 3 );



/*function custom_header_setup() { //Custom height header
	$args = array( 'height' => 350 );
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'custom_header_setup' );*/

function show_stars($postID){  //A simple query to get the votes and return the stars
	global $wpdb;
	
	$starsNumber= $wpdb->get_var($wpdb->prepare("SELECT stars FROM vc_places WHERE id = %s", $postID));
	
				
				switch ($starsNumber){
											
					case 0:
					$showStars = "<span>Not rated yet</span>";
					break;
					
					case 1:
					$showStars = "<i class='fa fa-star'></i>";
					break;
					
					case 2:
					$showStars = "<i class='fa fa-star'></i><i class='fa fa-star'></i>";
					break;
					
					case 3:
					$showStars = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					break;
					
					case 4:
					$showStars = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					break;
					
					case 5:
					$showStars = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					break;

				}
					
				return "<br><span class='enlinia'>".$showStars."</span>";
			} 	


function user_already_voted ($postID, $userID) { //Check if user already voted current place
	
	global $wpdb;
	
	$user_alreadyVoted = $wpdb->get_results($wpdb->prepare("SELECT id FROM vc_rating WHERE place_id = %s AND user_id = %s", $postID, $userID));
	
	if($user_alreadyVoted){
		$alreadyVoted = true;
	} else {
		$alreadyVoted = false;
	}
	return $alreadyVoted;
}



function multiexplode ($delimiters,$string) {
   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}


if ( ! function_exists( 'wpvegan_custom_wp_trim_excerpt' ) ) : 

    function wpvegan_custom_wp_trim_excerpt($wpvegan_excerpt) {
        global $post;
        $raw_excerpt = $wpvegan_excerpt;
        if ( '' == $wpvegan_excerpt ) {

            $wpvegan_excerpt = get_the_content('');
            $wpvegan_excerpt = strip_shortcodes($wpvegan_excerpt );
            $wpvegan_excerpt = apply_filters('the_content', $wpvegan_excerpt);
            $wpvegan_excerpt = substr($wpvegan_excerpt, 0, strpos( $wpvegan_excerpt, '</p>' ) + 4 );
            $wpvegan_excerpt = str_replace(']]>', ']]&gt;', $wpvegan_excerpt);

            $excerpt_end = ' <p>'.show_stars($post->ID).'</p><a href="'. esc_url( get_permalink() ) . '">' . '<i class="fa fa-chevron-circle-right"></i>&nbsp;' . sprintf(__( 'Rate' )) . '</a>'; 
            $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

            //$pos = strrpos($wpvegan_excerpt, '</');
            //if ($pos !== false)
                // Inside last HTML tag
                //$wpvegan_excerpt = substr_replace($wpvegan_excerpt, $excerpt_end, $pos, 0);
            //else
                // After the content
            $wpvegan_excerpt .= $excerpt_end;

            return $wpvegan_excerpt;

        }
        return apply_filters('wpvegan_custom_wp_trim_excerpt', $wpvegan_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpvegan_custom_wp_trim_excerpt');



/**Pagination for archive, taxonomy, category, tag and search results pages**/

function base_pagination() {
    global $wp_query;

    $big = 999999999; // This needs to be an unlikely integer


    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo '<div class="pagination">';
        echo $paginate_links;
        echo '</div><!--// end .pagination -->';
    }
}

/***Default settings for VeganCity***/

function settings_theme_setup() {
update_option( 'thumbnail_size_w', 650 );
update_option( 'thumbnail_size_h', 270 );
update_option( 'thumbnail_crop', 1 );
update_option( 'medium_size_w', 1400 );
update_option( 'medium_size_h', 700 );
update_option( 'large_size_w', 0 );
update_option( 'large_size_h', 0 );
update_option ('uploads_use_yearmonth_folders', 0);
update_option('blogdescription', 'Anywhere, anytime, anyplace');
update_option( 'default_comment_status', 'closed' );

$home = get_page_by_title( 'Home' );
update_option('show_on_front', 'page');
update_option('page_on_front', $home->ID);
update_option('posts_per_page', 9);



if( file_exists( ABSPATH . '/wp-admin/includes/taxonomy.php' ) ) {
	
	require_once( ABSPATH . '/wp-admin/includes/taxonomy.php' );

            if( ! category_exists( 'Places' ) ) {

                wp_create_category( 'Places' );
				
			}
			wp_insert_term('Restaurant', 'post_tag');
			wp_insert_term('Market', 'post_tag');
			wp_insert_term('Clothes shop', 'post_tag');
			wp_insert_term('Activism', 'post_tag');

}



    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%postname%/' );

}
add_action( 'after_setup_theme', 'settings_theme_setup' );


?>
