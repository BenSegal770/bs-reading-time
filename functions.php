<?php

if ( !function_exists( 'sanitize_array_field' ) ) {
    function sanitize_array_field( $array ) {
        
        if( is_array( $array ) ){
            echo 'bla';
            }
            
            return $array;
        }
        
        return array();
    }
}

if ( !function_exists( 'is_reading_time_post_supported' ) ) {
    function is_reading_time_post_supported( $post_id ) {
        $post_type = get_post_type( $post_id );
        $supported_post_types = get_option( 'rd_supported_post_types' );
        
        if( !is_array( $supported_post_types ) || !in_array( $post_type, $supported_post_types ) ){
            return false;
        }
        
        return true;
    }
}

?>