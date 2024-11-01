<?php
/*
Plugin Name: UXsniff Heatmaps and Session Recordings
description: A simple WordPress heatmap plugin to monitoring your user's behaviour, detect and report abnormal user activities. This plugin allows you to install UXsniff tracking code to your wordpress without editing your theme. The plugin also shows basic statistic about your user's behaviour and detect abnormal user activities. Some basic features such as Heatmaps, Clickmaps, Session recordings and Rage alerts are available within the plugin. Login to UXsniff for advanced functionality such as user journey, feedback widgets, on-site surveys and advanced reports.
Version: 1.2.4
Author: UX Sniff
Author URI: https://uxsniff.com
License: GPL2
*/
if( !defined( 'ABSPATH' ) ) exit;

require_once( plugin_dir_path (__FILE__) .'functions.php' );

add_action( 'admin_menu', 'uxsniff_info_menu' );  

add_action( 'admin_enqueue_scripts', 'uxsniff_enqueue_styles_script' );

add_action('wp_footer', 'uxsniff_frontendFooterScript');



if( !function_exists("uxsniff_add_plugin_page_settings_link") ) { 

function uxsniff_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'admin.php?page=uxsniff-info' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
// add settings link on the plugin page
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'uxsniff_add_plugin_page_settings_link');

}


if( !function_exists("uxsniff_info_menu") ) { 
// add admin menu
function uxsniff_info_menu(){    

	$footer_script = uxsniff_get_option_footer_script();
	$footer_domain = uxsniff_get_option_footer_domain();

	if($footer_script==''){ 
		$page_title = 'UX Sniff';   
		$menu_title = 'Settings';   
		$menu_slug  = 'uxsniff-info';   
		$function   = 'uxsniff_info_page'; 
		$parent_slug = 'uxsniff-info';
	} else {

		$page_title = 'Heatmaps';   
		$menu_title = 'Heatmaps';   
		$menu_slug  = 'uxsniff-heatmaps';   
		$function   = 'uxsniff_heatmaps_page';   
		$parent_slug = 'uxsniff-heatmaps';  

	}  
	$capability = 'manage_options';  
	$icon_url   = plugin_dir_url( __FILE__ ).'assets/img/logo.jpg'; 
	$position   = 80; 

	add_menu_page( $page_title, 'UX Sniff', $capability, $menu_slug, $function, $icon_url, $position ); 
	add_submenu_page($menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );


if($footer_script==''){

	$page_title = 'Heatmaps';   
	$menu_title = 'Heatmaps';   
	$capability = 'manage_options';   
	$menu_slug  = 'uxsniff-heatmaps';   
	$function   = 'uxsniff_heatmaps_page';   
	$icon_url   = 'dashicons-media-code';   
	$position   = 4; 

	add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );
}


  	$page_title = 'Recordings';   
    $menu_title = 'Recordings';   
    $capability = 'manage_options';   
    $menu_slug  = 'uxsniff-recordings';   
    $function   = 'uxsniff_recordings_page';   
    $icon_url   = 'dashicons-media-code';   
    $position   = 4; 

    add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );


    $page_title = 'Rage alerts';   
    $menu_title = 'Rage alerts';   
    $capability = 'manage_options';   
    $menu_slug  = 'uxsniff-rage-alerts';   
    $function   = 'uxsniff_rage_page';   
    $icon_url   = 'dashicons-media-code';   
    $position   = 4; 

    add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );


	add_action( 'admin_init', 'update_uxsniff_info' ); 




	if($footer_script!=''){

		$parent_slug = 'uxsniff-heatmaps';  	
		$page_title = 'UX Sniff Settings';   
		$menu_title = 'Settings';   
		$capability = 'manage_options';   
		$menu_slug  = 'uxsniff-info';   
		$function   = 'uxsniff_info_page';   
		$icon_url   = 'dashicons-chart-bar';  
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );
	}



} 

}



function uxsniff_info_page(){ 
  include( plugin_dir_path( __FILE__ ) . 'options.php' );
} 

function uxsniff_realtime_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'realtime.php' );

} 

function uxsniff_heatmaps_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'heatmaps.php' );

} 

function uxsniff_heatmap_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'heatmap.php' );

} 

function uxsniff_fsheatmap_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'fsheatmap.php' );

} 


function uxsniff_recordings_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'recordings.php' );

} 

function uxsniff_rage_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'rage.php' );

} 

function uxsniff_inspector_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'inspector.php' );

} 

function uxsniff_inspect_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'inspect.php' );

} 


function uxsniff_inspecturl_page(){ 

  include( plugin_dir_path( __FILE__ ) . 'inspect-url.php' );

} 

function update_uxsniff_info() {   

  register_setting( 'uxsniff-info-settings', 'uxsniff_info' ); 

} 



if( !function_exists("uxsniff_enqueue_styles_script") ) { 

function uxsniff_enqueue_styles_script()
{

    if( is_admin() ) {              

        $css= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/style.css";

        wp_enqueue_style( 'uxsniff-css', $css );
	    wp_enqueue_style( 'uxsniff-font-main-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/main.css");
	    wp_enqueue_style( 'uxsniff-google-font', "https://fonts.googleapis.com/css?family=Roboto+Slab");

	    wp_enqueue_style( 'uxsniff-datatable-bootstrap', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/dataTables.bootstrap.min.css");
		wp_enqueue_style( 'uxsniff-datatable-responsive', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/responsive.bootstrap.min.css");
		wp_enqueue_style( 'uxsniff-datatable-fixheader', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/fixedHeader.dataTables.min.css");

    wp_enqueue_style( 'uxsniff-bootstrap-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/bootstrap.min.css");

    wp_register_script( 'uxsniff_global_plugin_script', plugins_url('/assets/js/global.min.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'uxsniff_global_plugin_script' );

		wp_register_script( 'uxsniff_global_bootstrap_plugin_script', plugins_url('/assets/js/bootstrap.bundle.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'uxsniff_global_bootstrap_plugin_script' );

		wp_register_script( 'uxsniff_echarts_plugin_script', plugins_url('/assets/js/echarts.min.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'uxsniff_echarts_plugin_script' );

		wp_register_script( 'uxsniff_datatable_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/jquery.dataTables.min.js', array('jquery'));
    wp_enqueue_script( 'uxsniff_datatable_plugin_script' );

		wp_register_script( 'uxsniff_datatable_responsive_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/dataTables.responsive.min.js', array('jquery'));
    wp_enqueue_script( 'uxsniff_datatable_responsive_plugin_script' );

		wp_register_script( 'uxsniff_datatable_bootstrap_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/dataTables.bootstrap.min.js', array('jquery'));
    wp_enqueue_script( 'uxsniff_datatable_bootstrap_plugin_script' );

		wp_register_script( 'uxsniff_moment_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/moment.min.js', array('jquery'));
		wp_enqueue_script( 'uxsniff_moment_plugin_script' );


       

        

    }

}

}

if( !function_exists("uxsniff_frontendFooterScript") ) { 

	function uxsniff_frontendFooterScript(){
		
		uxsniff_output();
		
	}

}


function uxsniff_ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function uxsniff_matchElement($str){
    switch($str){
        case "A":
        return "Anchor Link <".strtolower($str).">";
        break;
        case "DIV":
        return "Division";
        case "IMG":
        return "Image";
        case "P":
        return "Paragraph";
        case "SECTION":
        return "Section";
        case "INPUT":
        return "Input";
        case "BUTTON":
        return "Button";
        default:
        return $str;    
    }
}
?>
