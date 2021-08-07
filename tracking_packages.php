<?php
/*
Plugin Name: Tracking Packages
Description: Tracking Packages destinations
Version: 0.1.0
Author: Raptor Web
Author URI:www.raptor-web.com
License: GPL2
*/

defined('ABSPATH') or die("Bye bye");

define('TP_PATH', plugin_dir_path(__FILE__));
define('TABLE_NAME', "tracking_packages");

include(TP_PATH . 'includes/functions.php');

register_activation_hook(__FILE__, 'tracking_packages_init');

add_shortcode('tracking_packages_shortcode', 'tracking_packages_form');

add_action("admin_menu", "tracking_packages_menu");

register_deactivation_hook(__FILE__, 'tracking_packages_desactivation');

wp_enqueue_style('css_public', plugins_url('./assets/css/public.css', __FILE__));
wp_enqueue_style('css_admin', plugins_url('./assets/css/admin.css', __FILE__));

