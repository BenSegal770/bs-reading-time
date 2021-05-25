<?php

class ReadingTimeCLI {
     
    function config( $args ) {
        switch( $args[ 0 ] ) {
            case 'get':
                $action = "get";
                break;
            
            case 'set':
                $action = "set";
                break;
            
            default:
                $action = "";
        }

        if( $action == "get" ) {
            $this->config_get();
        } elseif( $action == "set" ) {
            $this->config_set( $args );
        } else {
            WP_CLI::error( "Example: wp reading-time get/set" );
        }
    }

    function get( $args ){
        $post_id = empty( $args[ 0 ] ) ? 0 : intval( $args[ 0 ] );
        $reading_time = get_reading_time( $post_id );
        
        if( $reading_time > 0 ) {
            WP_CLI::success( "The post Reading Time is: " . $reading_time . " seconds."  );
        } else {
            WP_CLI::error( "This post not supported in the reading-time"  );
        }
    }

    // Example: wp reading-time set SUPPRTED_POST_TYPES post,page
    function config_set( $args ){

        $option_arg = empty( $args[ 1 ] ) ? "" : $args[ 1 ];

        if( $option_arg != "" ) {
            switch ( $args[ 1 ] ){
                case 'WORDS_PER_MINUTE':
                    $option = "rd_words_per_minute";
                    break;

                case 'ROUNDING_BEHAVIOR':
                    $option = "rd_rounding_behavior";
                    break;
            
                case 'SUPPORTED_POST_TYPES':
                    $option = "rd_supported_post_types";
                    break;

                default:
                    $option = '';
            }
        } else {
            $option = "";
        }

        if( $option == "" ){
            WP_CLI::error( "the option is not found. the options is: WORD_PER_MINUTE / ROUNDING_BEHAVIOR / SUPPORTED_POST_TYPES" );
            return;
        }

        $value_arg = empty( $args[ 2 ] ) ? "" : $args[ 2 ];
        if( $value_arg == "" ){
            WP_CLI::error( "you need to set a value." );
            return;
        }

        if( $option == "rd_words_per_minute" ){
            $value = intval( $value_arg );
        } elseif( $option == "rd_rounding_behavior" ) {
            if( $value_arg != "round_up" && $value_arg != "round_down"  ) {
                WP_CLI::error( "you can set a value 'round_up' or 'round_down'" );
                return;
            } else {
                $value = $value_arg;
            }
        } elseif( $option = "rd_supported_post_types" ) {
            $value = explode( ",", $value_arg );
        }

        update_option( $option, $value );
        WP_CLI::success( "The option is updated" );
    }

    function config_get(){
        $words_per_minute = get_option( 'rd_words_per_minute' );
        $rounding_behavior = get_option( 'rd_rounding_behavior' );
        $supported_post_types = get_option( 'rd_supported_post_types' );
        $supported_post_types = implode( ",", $supported_post_types );

        WP_CLI::success( 
            "WORDS_PER_MINUTE: {$words_per_minute}
         ROUNDING_BEHAVIOR: {$rounding_behavior}
         SUPPORTED_POST_TYPES: {$supported_post_types}"
         );
    }

    function clear_cache(){
        
        $supported_post_types = get_option( 'rd_supported_post_types' );

        $args = array(
            "post_type" => $supported_post_types,
            "posts_per_page" => -1
        );

        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            
            while ( $query->have_posts() ) {
                $query->the_post();
                
                $post_id = get_the_ID();
                delete_post_meta( $post_id, "reading_time" );

                calculate_reading_time( $post_id );
            }

            WP_CLI::success( "The Reading-Time cache has been cleared." );
        } else {
            WP_CLI::error( "No posts found." );
        }

        wp_reset_postdata();
    }
}

if ( class_exists( 'WP_CLI' ) ) {
    WP_CLI::add_command( 'reading-time', 'ReadingTimeCLI' );
    WP_CLI::add_command( 'reading-time clear-cache',array( 'ReadingTimeCLI', 'clear_cache' ) );
}

?>