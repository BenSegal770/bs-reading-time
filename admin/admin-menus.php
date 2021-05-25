<?php

add_action( 'admin_menu', 'rd_add_menus' );
function rd_add_menus(){
    add_options_page(
        'Reading Time Settings',
        'Reading Time',
        'manage_options',
        'rd_settings_form',
        'rd_settings_form'
    );
}

?>