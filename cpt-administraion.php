<?php
/*
Plugin Name: Custom Post Types Administration 
Plugin URI: 
Description: This is a plugin that manages custom post types
Author: Noman Akram
Author URI: 
Text Domain: cpt-administration
Version: 1.0.0
*/

define( 'CPTA_VERSION', '1.0.0' );

define( 'CPTA_PLUGIN_PATH', dirname( __FILE__ ) );

define( 'CPTA_PLUGIN_BASENAME',  basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

define( 'CPTA_PLUGIN_URL', plugins_url( '', CPTA_PLUGIN_BASENAME ) );

define( 'CPTA_CONTROLLER_PATH',   CPTA_PLUGIN_PATH  . DIRECTORY_SEPARATOR . 'controller' );

define( 'CPTA_LIB_PATH', CPTA_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'lib' );



require_once CPTA_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'CPTAMainController.php';
require_once CPTA_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'CPTAListController.php';
require_once CPTA_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'CustomPostController.php';

require_once CPTA_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'Request.php';

$main_controller = new CPTAMainController();
