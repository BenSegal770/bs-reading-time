<?php

function rd_setup_options(){
    update_option( 'rd_words_per_minute', 200 );
    update_option( 'rd_rounding_behavior', "round_up" );
    update_option( 'rd_supported_post_types', array( "post" ) );
}

function rd_update_settings()
{
    if( isset( $_POST[ 'submit' ] ) ){

        $words_per_minute = empty( $_POST[ 'rd_words_per_minute' ] ) ? 200 : intval( $_POST[ 'rd_words_per_minute' ] );
        $supported_post_types = empty( $_POST[ 'rd_supported_post_types' ] ) ? array( ) : sanitize_array_field ( $_POST[ 'rd_supported_post_types' ] );
        
        switch( $_POST[ 'rd_rounding_behavior' ] ) {
            case 'round_up':
                $rounding_behavior = "round_up";
                break;
                
            case 'round_down':
                $rounding_behavior = "round_down";
                break;
                
            default:
                $rounding_behavior = "round_up";
        }
        

        update_option( 'rd_words_per_minute', $words_per_minute );
        update_option( 'rd_rounding_behavior', $rounding_behavior );
        update_option( 'rd_supported_post_types', $supported_post_types ); 
    }
}
add_action('admin_init', 'rd_update_settings');


function rd_settings_form()
{
	if ( !current_user_can('manage_options') ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    $words_per_minute = get_option( 'rd_words_per_minute' );
    $rounding_behavior = get_option( 'rd_rounding_behavior' );
    $supported_post_types = get_option( 'rd_supported_post_types' );
    
    $round_up_selected = ( $rounding_behavior == "round_up" ) ? "selected" : "";
    $round_down_selected = ( $rounding_behavior == "round_down" ) ? "selected" : "";
    
    $post_types = get_post_types();
 
?>
<h1>הגדרות השו"ת</h1>

<form method="post" action="">
    <table>
        <tr>
			<td valign="top"><?php _e("No. of Words Per Minute", 'bs-reading-time'); ?>:</td>
			<td>
                <input type="number" name="rd_words_per_minute" value="<?php echo $words_per_minute; ?>" size="3" /><br />
				<span class="description"><?php _e("description", 'bs-reading-time'); ?></span><br /><br />
            </td>
		</tr>
        
    	<tr>
			<td valign="top"><?php _e("Rounding behavior", 'bs-reading-time'); ?>:</td>
			<td>
                <select name="rd_rounding_behavior">
					<option <?php echo $round_up_selected; ?> value="round_up"> <?php _e('Round Up', 'bs-reading-time'); ?></option>
					<option <?php echo $round_down_selected; ?> value="round_down"> <?php _e('Round Down',  'bs-reading-time'); ?></option>
				</select><br />
				<span class="description"><?php _e("Round up in ½ minute steps Or Round down in ½ minute steps", 'bs-reading-time'); ?></span><br /><br />
            </td>
		</tr>
        
        <tr>
			<td valign="top"><?php _e("Supported Post Types", 'bs-reading-time'); ?>:</td>
			<td>
                <?php foreach( $post_types as $post_type => $post_type_name ) {  
                    $post_type_checked = in_array( $post_type, $supported_post_types ) ? "checked" : "";    
                ?>
                <input id="supported-post-type-<?php echo $post_type; ?>" type="checkbox" name="rd_supported_post_types[]" value="<?php echo $post_type; ?>" <?php echo $post_type_checked; ?> />
                <label for="supported-post-type-<?php echo $post_type; ?>"><?php echo $post_type_name; ?></label><br /><br />
                <?php } ?><br />

            </td>
		</tr>
        
    </table>
    <?php submit_button(); ?>
</form>
<?php
} 


?>