<?php


function tp_admin_menu()
{
    add_menu_page('Tracking Package','Tracking Package','manage_options',TP_PATH . '/admin/view.php');
}
?>