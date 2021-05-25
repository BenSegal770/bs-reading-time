<?php

/*
Plugin Name: Reading Time
Plugin URI: https://tech.marketing
Author: Ben Segal
Version: 1.0.0
*/

include( "functions.php" );

include( "admin/admin-menus.php" );
include( "admin/admin-settings.php" );
include( "admin/admin-post.php" );

include( "include/inc-label.php" );
include( "include/inc-calculate.php" );
include( "include/inc-cli.php" );

function rd_plugin_activate() {
    rd_setup_options();
}

register_activation_hook( __FILE__, 'rd_plugin_activate' );

?>