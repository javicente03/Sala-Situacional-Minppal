<?php

function Admin_Users_Get(){
    $title = 'MINPPAL - Administrador de Usuarios';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    echo 'Admin Users';
    include_once 'src/blocks/footer.php';
}