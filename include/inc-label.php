<?php

if ( !function_exists( 'get_reading_time' ) ) {
    function get_reading_time( $post_id = 0 ){
        $post_id = intval( $post_id );
        $post_id = ( $post_id == 0 ) ? get_the_ID() : $post_id;
        
        if( !is_reading_time_post_supported($post_id) ){
            return;
        }
        
        $reading_time = get_post_meta( $post_id, "reading_time", true );
        print_r( $reading_time );
        if( empty( $reading_time ) ) {
            $reading_time = calculate_reading_time( $post_id );
        } else {
            $words_per_minute = get_option( 'rd_words_per_minute' );
            if( $reading_time[ 'words' ] != $words_per_minute ){
                $reading_time = calculate_reading_time( $post_id );
            }
        }
        
        return $reading_time[ 'seconds' ];
    }
}


if ( !function_exists( 'the_reading_time' ) ) {
    function the_reading_time(){
        echo get_the_ID();
    }
}


add_shortcode( "reading_time", 'shortcode_reading_time', 100 );
function shortcode_reading_time(){
    ob_start();

    $reading_time = get_reading_time(); 
    ?>
    <style>
    .bs-reading-time span { font-weight: bold; }
    </style>
    
    <div class="bs-reading-time">
        <span><?php _e( "Reading Time:", 'bs-reading-time' ) ?></span> <?php echo $reading_time ?> <?php echo _e( "Seconds", 'bs-reading-time' );?>
    </div>
    
    <?php
    return ob_get_clean();
}


?>