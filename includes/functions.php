<?php
function tracking_packages_init()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . TABLE_NAME . ' ('
        . 'id INT NOT NULL AUTO_INCREMENT,'
        . 'sendto TEXT NOT NULL,'
        . 'guidenumber VARCHAR(256) NOT NULL,'
        . 'sendnumber VARCHAR(256) NOT NULL,'
        . 'chargedest TEXT NOT NULL,'
        . 'status VARCHAR(64) NOT NULL,'
        . 'PRIMARY KEY (id)'
        . ')' . $charset_collate . ';';
    // La función dbDelta que nos permite crear tablas de manera segura se
    // define en el fichero upgrade.php que se incluye a continuación
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

function tracking_packages_desactivation()
{
    global $wpdb;
    $sql = 'DROP TABLE ' . $wpdb->prefix . TABLE_NAME . ';';
    $wpdb->get_results($sql);

}

function tracking_packages_form()
{
    ob_start();
    include TP_PATH . 'public/view.php';
    return ob_get_clean();
}

function tracking_packages_menu()
{
    add_menu_page("Seguimiento de Paquetes", "Seguimiento de Paquetes", "manage_options",
        "tracking_packages_list", "tracking_packages_list", "dashicons-feedback", 75);

    //adding submenu to a menu
    add_submenu_page('tracking_packages_list',//parent page slug
        'Seguimiento de Paquetes - Agregar Nuevo',//page title
        'Agregar Nuevo',//menu titel
        'manage_options',//manage optios
        'tracking_packages_create',//slug
        'tracking_packages_create'//function
    );

    add_submenu_page(null,//parent page slug
        'Seguimiento de Paquetes - Actualizar ',//$page_title
        'Actualizar',// $menu_title
        'manage_options',// $capability
        'tracking_packages_update',// $menu_slug,
        'tracking_packages_update'// $function
    );

    add_submenu_page(null,//parent page slug
        'Seguimiento de Paquetes - Eliminar ',//$page_title
        'Actualizar',// $menu_title
        'manage_options',// $capability
        'tracking_packages_delete',// $menu_slug,
        'tracking_packages_delete'// $function
    );
}

function tracking_packages_list()
{
    include TP_PATH . 'admin/view.php';
    return ob_get_clean();
}

function tracking_packages_create()
{
    if (!current_user_can('manage_options')) wp_die(__(
        'No tienes suficientes permisos para acceder a esta página.'));
    ?>
    <div class="card">
        <h1>Agregar Nuevo</h1>
        <form action="<?php get_the_permalink(); ?>" method="post" class="package-info-form">
            <table class="form-table" role="presentation">
                <tr class="form-field">
                    <th scope="row"><label>¿A quién se le envía?:</label></th>
                    <td><input type="text" name="sendto" id="sendto" class="form-field" required/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Número de Guía:</label></th>
                    <td><input type="text" name="guideno" id="guideno" class="form-field" required/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>No de Envío:</label></th>
                    <td><input type="text" name="sendno" id="sendno" class="form-field" required/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Entrega en destino:</label></label></th>
                    <td><input type="text" name="chargedest" id="chargedest" class="form-field" required/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Estado:</label></label></th>
                    <td>
                        <select name="package_status" required>
                            <option value="1">Procesando</option>
                            <option value="2">En tránsito</option>
                            <option value="3">En destino</option>
                        </select>
                    </td>
                </tr>
                <tr class="form-field">
                    <th><input type="submit" name="button-create" class="button button-primary" value="Guardar"/></th>
                </tr>
            </table>
        </form>
    </div>

    <?php

    if (!empty($_POST['sendto']) && !empty($_POST['guideno']) && !empty($_POST['sendno']) && !empty($_POST['chargedest'])) {
        $sendto = sanitize_text_field($_POST['sendto']);
        $guideno = $_POST['guideno'];
        $sendno = $_POST['sendno'];
        $chargedest = $_POST['chargedest'];
        $package_status = $_POST['package_status'];

        global $wpdb;
        $tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;
        $status=array('Procesando', 'En tránsito', 'En destino');

        $datainserted = $wpdb->insert($tabla_tracking_packages,
            array(
                'sendto' => $sendto,
                'guidenumber' => $guideno,
                'sendnumber' => $sendno,
                'chargedest' => $chargedest,
                'status' => $status[($package_status-1)],
            )
        );

        if ($datainserted) {
            echo "<div class='success message'>.:. Datos guardados satisfactoriamente .:.</div>";
        } else {
            echo "<div class='alert message'>.:. Error al enviar, verifique los datos .:.</div>";
        }
    }
}

function tracking_packages_update()
{
    if (!current_user_can('manage_options')) wp_die(__(
        'No tienes suficientes permisos para acceder a esta página.'));

    $id = $_GET['id'];
    global $wpdb;
    $tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;
    $results = $wpdb->get_results("SELECT * FROM $tabla_tracking_packages WHERE id=$id");
    ?>
    <div class="card">
        <h1>Editar datos</h1>
        <form action="?page=tracking_packages_list" method="post" class="package-info-form">
            <table class="form-table" role="presentation">
                <tr class="form-field hidden">
                    <td><input type="text" name="id" id="sendto" class="form-field" value="<?= $results[0]->id; ?>"/>
                    </td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>¿A quién se le envía?:</label></th>
                    <td><input type="text" name="sendto" id="sendto" class="form-field"
                               value="<?= $results[0]->sendto; ?>"/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Número de Guía:</label></th>
                    <td><input type="text" name="guideno" id="guideno" class="form-field"
                               value="<?= $results[0]->guidenumber; ?>"/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>No de Envío:</label></th>
                    <td><input type="text" name="sendno" id="sendno" class="form-field"
                               value="<?= $results[0]->sendnumber; ?>"/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Entrega en destino:</label></label></th>
                    <td><input type="text" name="chargedest" id="chargedest" class="form-field"
                               value="<?= $results[0]->chargedest; ?>"/></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label>Estado:</label></label></th>
                    <td>
                        <?php $status=array('Procesando', 'En tránsito', 'En destino'); ?>
                        <select name="package_status" required>
                            <?php foreach ($status as $key=>$value){ ?>
                            <?php 
                                if ($results[0]->status==$value) {?>
                                    <option value="<?php print($key+1)?>" selected><?php print($value)?></option>
                                <?php } else { ?>
                                    <option value="<?php print($key+1)?>"><?php print($value)?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="form-field">
                    <th><input type="submit" name="button-update" class="button button-primary" value="Guardar"/></th>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

function tracking_packages_delete()
{
    if (isset($_GET['id'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . TABLE_NAME;
        $id = $_GET['id'];
        $isdeleted = $wpdb->delete($table_name, array('id' => $id));

        if ($isdeleted) {
            echo "<div class='card'><p class='success'>.:. Seguimiento de paquete eliminado satisfactoriamente .:.</p></div>";
        } else {
            echo "<div class='card'><p class='alert'>.:. Error al eliminar el seguimiento del paquete .:.</p></div>";
        }
    }
    ?>
    <meta http-equiv="refresh" content="1; url='?page=tracking_packages_list'"/>
    <?php
}