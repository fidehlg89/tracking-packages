<?php
/*
Plugin Name: Tracking Package
Description: Tracking Packages destinations
Version: 0.1.0
Author: Raptor Web
Author URI:www.raptor-web.com
License: GPL2
*/

defined('ABSPATH') or die("Bye bye");

define('TP_PATH',plugin_dir_path(__FILE__));

define ('TABLE_NAME',  "tracking_package");

include(TP_PATH . 'includes/functions.php');

include(TP_PATH.'/includes/options.php');

register_activation_hook(__FILE__,'tp_plugin_activate');

register_deactivation_hook(__FILE__, 'tp_plugin_desactivation');

add_action( 'admin_menu', 'tp_admin_menu' );

add_shortcode('tracking_package_shortcode', 'tp_shortcode');

add_action( 'admin_enqueue_scripts', 'tracking_packages_admin_assets');
add_action( 'wp_enqueue_scripts', 'tracking_packages_assets' );

?>