<?php

if (!current_user_can('manage_options')) wp_die(__(
    'No tienes suficientes permisos para acceder a esta página.'));

global $wpdb;
$tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;

$tableheaders = array('Enviado a', 'Número de guía', 'Número de envío', 'Entrega destino', 'Acciones');
$tabledata = $wpdb->get_results("SELECT * FROM " . $tabla_tracking_packages);
?>
    <div class="tracking-package-list">
        <div class="wrap">
            <h1>Listado de Paquetes</h1>
            <a href="?page=tracking_packages_create" class="button button-primary" style="margin-bottom: 10px;">Agregar Paquete</a>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <?php foreach ($tableheaders as $head) { ?>
                        <th><?php print($head) ?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($tabledata)){
                    echo '<tr class="no-items"><td colspan="5">La tabla no contiene datos</td></tr>';
                }?>
                <?php foreach ($tabledata as $data) {
                    ?>
                    <tr>
                        <td><?php print($data->sendto) ?></td>
                        <td><?php print($data->guidenumber) ?></td>
                        <td><?php print($data->sendnumber) ?></td>
                        <td><?php print($data->chargedest) ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=tracking_packages_update&id=' . $data->id); ?>">Editar</a>
                            |
                            <a href="<?php echo admin_url('admin.php?page=tracking_packages_delete&id=' . $data->id); ?>">
                                Eliminar</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
ob_start();
?>