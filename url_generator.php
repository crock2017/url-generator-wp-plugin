<?php 
/*
  Plugin Name: url_generator
  Plugin URI: http://none.none
  Description: creates url links. Use shortCode [url_generator]
  Version: 1.0.0
  Author: crock@vodafone.de
  Author URI: http://none.none
 */

add_action('wp_enqueue_scripts','urlGenerator_scripts');

function urlGenerator_scripts(){
	//== bootstrap===
$bootstrap_UrlGen = get_option('urlGenerator_bootstrap');
	if ($bootstrap_UrlGen == '1') {
wp_register_style('urlGen-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
wp_enqueue_style('urlGen-bootstrap');	
wp_register_script('urlGen-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',  array( 'jquery' ) );
wp_enqueue_script('urlGen-bootstrap');
	}

	//=== css===
wp_register_style('urlgenerator-style', plugins_url('url_generator.css', __FILE__) );	
wp_enqueue_style( 'urlgenerator-style' );
	
	//=== ajax object & ajax url & front js===
wp_enqueue_script( 'front_urlGenerator',  plugin_dir_url( __FILE__ ) . 'url_generator.js',  array( 'jquery' ));
wp_localize_script( 'front_urlGenerator', 'front_urlGeneratorajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	
	//=== ajax object & plugin url ===
wp_localize_script( 'front_urlGenerator', 'front_urlGenerator_url', array( 'pluginUrl' => plugins_url() ) );

}

// ==== ajax process getContent ======
add_action( "wp_ajax_fronturlGeneratoraction", "getContent" );
add_action( "wp_ajax_nopriv_fronturlGeneratoraction", "getContent" );

// ====create custom plugin settings menu calc_admin_page function===
add_action('admin_menu', 'admin_menu_urlGenerator');
function admin_menu_urlGenerator() {
	add_menu_page('Settings', 'Url generator', 'administrator', 'urlGenerator_menu', 'urlGenerator_admin_page');	
}

// ============ custom plugin menu =======================================
function urlGenerator_admin_page () {
	 if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }
	// =====bind BD=======
	if(isset($_POST['submit'])){
		
		if((isset($_POST['urlGenerator_bootstrap']) ) && $_REQUEST['page'] == 'urlGenerator_menu') {
			update_option('urlGenerator_bootstrap', $_POST['urlGenerator_bootstrap']);
		} 
		if( $_REQUEST['page'] == 'urlGenerator_menu' && !isset($_POST['urlGenerator_bootstrap']) ){
			update_option('urlGenerator_bootstrap', 0);
		}
	} 
?>
<form method='post' action=''>
		  
	<?php  //======= add sections & fields for tabs ====
	
		settings_fields( 'urlGenerator_style' ); 
    	do_settings_sections('urlGenerator_style');
	

		    submit_button(); 
		  ?>

	  </form>
	
<?php
}

//========call register Style settings section & its fields function===============================
add_action('admin_init', 'register_style_urlGenerator_settings');

function register_style_urlGenerator_settings() {
	
	add_settings_section('style_urlGenerator_section', 'Options', 'style_urlGenerator','urlGenerator_style');
	
	add_settings_field('Style','URL generator style','style_options_urlGenerator', 'urlGenerator_style', 'style_urlGenerator_section');
	
	register_setting('urlGenerator_style', 'urlGenerator_style');
					
}

		//==== Style section=============
function style_urlGenerator(){
	?>
<p>WARNING!</p>
<p>Disclaimer 1: Do not use this technique to take other’s intellectual property or copyright material.  This is only meant to be used on content you already own, or have permission to use.
</br>
Disclaimer 2: The possibility of having a cross site scripting attack is very real by using this technique – below, I’ve added a line which strips out any inline JavaScript “script” tags for this very reason – I highly recommend you do not remove that security precaution.</p>
</br>
<hr>
<p>Please, check box if you need load bootstrap library for "URL generator" plugin</p>
<?php
}

		//======= Style fields==========
function style_options_urlGenerator(){
	$checked_UrlGen = get_option('urlGenerator_bootstrap');
	if($checked_UrlGen == '1') $checked_UrlGen = 'checked';
	?>
	<table class='form-table'>
		  <tr valing='top'>
			  <th scope='row'>Load bootstrap</th>
			  <td><input type='checkbox' name='urlGenerator_bootstrap' <?=$checked_UrlGen; ?> value="1"/></td>
			  </tr>	 
		  </table>
<?php
}
//========== ajax =====================
function getContent(){
	$url = '';
	if(isset($_POST['url']))$url = $_POST['url'];
	//$file_get_contents($url);
	$opts = array(
  	'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: ru\r\n" .
              "Cookie: foo=bar\r\n"
  )
);
	

//$ctx = stream_context_create($opts);
$c = file_get_contents($url, false, $ctx);	
	
	
	if($c) {
		$html = new DOMDocument();
		$html->loadHTML($c);
		$html->preserveWhiteSpace = false;
		$title = $html->getElementsByTagName('title')[0]->nodeValue;
		$h1 = $html->getElementsByTagName('h1')[0]->nodeValue;
		$tags = get_meta_tags($url);
		$desc = $tags['twitter:description'];
	if(!$desc){
		$desc = $tags['description'];
	}	
	if(!$desc) {
		$desc = 'Не указано в meta tags';
	}
		
	$return_array =array (
		title=> $title,
		h1=> $h1,
		desc=> $desc
	);	
		echo json_encode($return_array);
	}else {
		echo 'error';
	}
	 wp_die();
}

//========== Register a new shortcode: [url_generator]================
add_shortcode( 'url_generator', 'urlGenerator_shortcode' );

function urlGenerator_shortcode() {
    ob_start();
	
   include( plugin_dir_path( __FILE__ ) . 'url_generator.html.php'); 
	
    return ob_get_clean();
}