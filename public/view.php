<form action="<?php get_the_permalink(); ?>" method="post" id="search-package" class="search-package">
    <div class="form-input">
        <input type="text" name="search-value" id="search-value"
               placeholder="Introduzca un número de envío" required/>
    </div>
    <div class="form-input">
        <input type="submit" value="Buscar" class="searchsubmit"/>
    </div>
</form>
<?php

if (!empty($_POST) && $_POST['search-value'] != '') {

    global $wpdb;

    $search_value = $_POST['search-value'];

    $tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;

    $search_result = $wpdb->get_results("SELECT * FROM " . $tabla_tracking_packages . " where sendnumber=" . $search_value . ";");

    echo '<div>Resultados  de la búsqueda: ' . $search_value.'</div>';

    if (empty($search_result)) {
        echo '<p>Lo sentimos la búsqueda no arrojó resultados. Para mayor información puede contactarnos al correo atencionalcliente@martelexpresssa.com</p>';
    } else {
        $status=array('Procesando', 'En tránsito', 'En destino');
        foreach ($search_result as $result) {
            ?>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="form-field">
                            <b>Enviado a: </b>
                            <span><?php echo $result->sendto; ?></span>
                        </div>
                        <div class="form-field">
                            <b>Número de guía: </b>
                            <span><?php echo $result->guidenumber; ?></span>
                        </div>
                        <div class="form-field">
                            <b>Número de envío: </b>
                            <span><?php echo $result->sendnumber; ?></span>
                        </div>
                        <div class="form-field">
                            <b>Entrega en destino a cargo de: </b>
                            <span><?php echo $result->chargedest; ?></span>
                        </div>
                        <div class="form-field">
                            <b>Estado: </b>
                            <span><?php echo $status[($result->status-1)]; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
