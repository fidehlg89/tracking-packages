<?php

function package_search_public_view()
{
    if (!empty($_POST['search-value'])) {

        global $wpdb;

        $search_value = $_POST['search-value'];

        $tabla_tracking_packages = $wpdb->prefix . TABLE_NAME;

        $search_result = $wpdb->get_results("SELECT * FROM " . $tabla_tracking_packages . " where sendnumber=" . $search_value . ";");

        echo "Resultados  de la búsqueda: " . $search_value;

        foreach ($search_result as $result) {
            ?>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="form-field">
                            <label>Enviado a:</label>
                            <span><?php $result->sendto; ?></span>
                        </div>
                        <div class="form-field">
                            <label>Número de guía: </label>
                            <span><?php $result->guidenumber; ?></span>
                        </div>
                        <div class="form-field">
                            <label>Número de envío: </label>
                            <span><?php $result->sendnumber; ?></span>
                        </div>
                        <div class="form-field">
                            <label>Entrega en destino a cargo de:</label>
                            <span><?php $result->chargedest; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ob_start()
    ?>
    <?php
}

?>