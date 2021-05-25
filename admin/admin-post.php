<?php

//add_action( 'wp_insert_post', 'save_post_reading_time', 100, 2 );
add_action( 'save_post', 'save_post_reading_time', 100, 2 );
function save_post_reading_time( $post_id, $post ){
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    
    if( !is_reading_time_post_supported( $post_id ) ){
        return;
    }
    
    calculate_reading_time( $post );
}

?>