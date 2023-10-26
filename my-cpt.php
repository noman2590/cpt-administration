<?php
/*
Plugin Name: My Custom Post Types 
Plugin URI: 
Description: This is a plugin that manages custom post types
Author: Noman Akram
Author URI: 
Text Domain: my-custom-post-types
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'MCPT_VERSION', '1.0.0' );

define( 'MCPT_PLUGIN_PATH', dirname( __FILE__ ) );

define( 'MCPT_PLUGIN_BASENAME', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

define( 'MCPT_PLUGIN_URL', plugins_url( '', MCPT_PLUGIN_BASENAME ) );

define( 'MCPT_CONTROLLER_PATH', MCPT_PLUGIN_PATH  . DIRECTORY_SEPARATOR . 'controller' );

define( 'MCPT_LIB_PATH', MCPT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'lib' );

require_once MCPT_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'MCPTMainController.php';
require_once MCPT_CONTROLLER_PATH . DIRECTORY_SEPARATOR . 'MCPTListController.php';
require_once MCPT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'Request.php';

$main_controller = new MCPTMainController();
