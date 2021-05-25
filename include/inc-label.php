<?php

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