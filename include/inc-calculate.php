<?php

if ( !function_exists( 'calculate_reading_time' ) ) {
    function calculate_reading_time( $post ){
        
        if( is_numeric( $post ) ) {
            $post_id = $post;
            $post_content = get_the_content( $post );
        } else {
            $post_id = $post->ID;
            $post_content = $post->post_content;
        }
        
        
        $post_content = sanitize_text_field( $post_content );
        $post_content = strip_shortcodes( $post_content );
        
        $words_per_minute = get_option( 'rd_words_per_minute' );
        $content_words = str_word_count( $post_content );
        
        $rounding_behavior = get_option( 'rd_rounding_behavior' );
        $round_mode = ( $rounding_behavior == "round_up" ) ? PHP_ROUND_HALF_UP : PHP_ROUND_HALF_DOWN;
        
        $calculate_seconds = 60 * ( $content_words / $words_per_minute );
        $calculate_seconds = round( $calculate_seconds, 0, $round_mode );
        
        $reading_time = array( 
            "seconds" => $calculate_seconds,
            "words" => $words_per_minute
        );
        
        update_post_meta( $post_id, "reading_time", $reading_time );
        
        return $reading_time;
    }
}



?>