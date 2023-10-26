<?php
/*
Plugin Name: WP Custom Post Types 
Plugin URI: 
Description: This is a plugin that manages custom post types
Author: Noman Akram
Author URI: 
Text Domain: wp-cpt
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WPCPT_VERSION', '1.0.0' );

define( 'WPCPT_PLUGIN_PATH', dirname( __FILE__ ) );

define( 'WPCPT_PLUGIN_BASENAME',  basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

define( 'WPCPT_PLUGIN_URL', plugins_url( '', WPCPT_PLUGIN_BASENAME ) );

define( 'WPCPT_CONTROLLER_PATH',   WPCPT_PLUGIN_PATH  . DIRECTORY_SEPARATOR . 'controller' );

define( 'WPCPT_LIB_PATH', WPCPT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'lib' );

require_once WPCPT_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'WPCPTMainController.php';
require_once WPCPT_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'WPCPTListController.php';
require_once WPCPT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'Request.php';

$main_controller = new WPCPTMainController();
