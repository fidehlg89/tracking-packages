<?php


function tp_plugin_activate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.TABLE_NAME.' ('
        .'id INT NOT NULL AUTO_INCREMENT,'
        .'sendto TEXT NOT NULL,'
        .'guidenumber VARCHAR(256) NOT NULL,'
        .'sendnumber VARCHAR(256) NOT NULL UNIQUE,'
        .'chargedest TEXT NOT NULL,'
        .'PRIMARY KEY (id)'
        .')'.$charset_collate.';';

    $wpdb->get_results($sql);

    //A partir de aquí escribe todas las tareas que quieres realizar en la activación
    //Vas a añadir una función nueva. La sintaxis de add_option es la siguiente:add_option($nombre,$valor,'',$cargaautomatica)
    add_option('tracking-package',255,'','yes');
}

function tp_plugin_desactivation()
{
    global $wpdb;
    $sql = 'DROP TABLE ' . $wpdb->prefix .TABLE_NAME .';';
    $wpdb->get_results($sql);

}

function tp_shortcode(){
    ob_start();
    include(TP_PATH . '/public/view.php');
    return ob_get_clean();
}

function tracking_packages_admin_assets(){
    wp_enqueue_style('css_admin', plugins_url('../assets/css/admin.css', __FILE__));
}

function tracking_packages_assets(){
    wp_enqueue_style('css_public', plugins_url('../assets/css/public.css', __FILE__));
}