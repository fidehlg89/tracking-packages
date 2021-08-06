<?php
if (!current_user_can('manage_options')) wp_die(__(
    'No tienes suficientes permisos para acceder a esta página.'));
?>

<div class="container">
    <div class="card">
        <div class="card-head"><h3>Seguimiento de Paquetes</h3></div>
        <div class="card-body">
            <form action="<?php get_the_permalink(); ?>" method="post" class="package-info-form">
                <table class="form-table" role="presentation">
                    <tr class="form-field">
                        <th scope="row"><label>¿A quién se le envía?:</label></th>
                        <td><input type="text" name="sendto" id="sendto" class="form-field" required/> </td>
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
                        <th><input type="submit" class="button button-primary" value="Save Package Information"/></th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php

if (!empty($_POST['sendto']) && !empty($_POST['guideno']) && !empty($_POST['sendno']) && !empty($_POST['chargedest'])) {

    $sendto = sanitize_text_field($_POST['sendto']);
    $guideno = $_POST['guideno'];
    $sendno = $_POST['sendno'];
    $chargedest = $_POST['chargedest'];

    $tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;

    global $wpdb;

    $datainserted=$wpdb->insert($tabla_tracking_packages,
        array(
            'sendto' => $sendto,
            'guidenumber' => $guideno,
            'sendnumber' => $sendno,
            'chargedest' => $chargedest,
        )
    );

    if ($datainserted){
        echo "<div class='success message'>.:. Datos guardados satisfactoriamente .:.</div>";
    }else {
        echo "<div class='alert message'>.:. Error al enviar, verifique los datos .:.</div>";
    }
}
ob_start();
?>