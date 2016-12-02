<?php
/**
 * Plugin Name: Estimation of the reading time
 * Description: Plugin partiel  - Announce the reading time of an article
 * Author:      Tess Tilmont
 * Version:     0.1
 * Text Domain: reading_time_domain
 */


defined( 'ABSPATH' )
 or die ( 'No direct load !' );

define( 'READING_TIME_DIR', plugin_dir_path( __FILE__ ) );
define( 'READING_TIME_URL', plugin_dir_url( __FILE__ ) );

require_once( READING_TIME_DIR . 'inc/function.php' );


function my_func_enqueue_style(){
	wp_enqueue_style( 'my-css', plugins_url('reading_time/css/style.css'), true );
}
add_action('wp_enqueue_scripts', 'my_func_enqueue_style');


// Translation function
function reading_time_init() {
	load_plugin_textdomain(
		'reading_time_domain',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'reading_time_init' );


