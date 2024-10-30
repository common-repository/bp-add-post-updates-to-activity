<?php

if(!defined('ABSPATH')) {
	exit;
}
// This page maps out the admin Settings page and adds the Options into the WPdb

// Create Menu Option
add_action( 'admin_menu', 'bpapu_admin_add_page' );

function bpapu_admin_add_page() {
	
	$options_page = sanitize_text_field(esc_attr_x('BP Add Post Updates To Activity','bp-add-post-updates-to-activity'));
	
	add_options_page( $options_page, $options_page, 'manage_options', 'bpapu', 'bpapu_options_page' );

}


// Construct the Save Changes button
function bpapu_options_page() {

?>
	
	<div class="wrap">
		
		<h2><?php sanitize_text_field(esc_attr_e( 'BP Add Post Updates to Activity', 'bp-add-post-updates-to-activity' )) ?></h2>
		
		<form action="options.php" method="post">
			
			<?php settings_fields( 'bpapu' ); ?>
			
			<?php do_settings_sections( 'bpapu' ); ?>
			
			<input name="Submit" type="submit" value="<?php sanitize_text_field(esc_attr_e( 'Save Changes', 'bp-add-post-updates-to-activity' )); ?>" class="button button-primary" />
		
		</form>
	
	</div>
	
<?php
}

add_action( 'admin_init', 'bpapu_admin_init' );

//Set up the Settings Sections and Fields
function bpapu_admin_init(){
	// Create Settings
	$option_group = 'bpapu';
	$option_name = 'bpapu_post_types';
	
	register_setting( $option_group, $option_name );

	$minimum_delay_option = 'bpapu_minimum_delay';
	register_setting( $option_group, $minimum_delay_option );
	
	$content_option = 'bpapu_content_option';
	register_setting($option_group,$content_option );

	// Create Settings page Section for BP Add Post Updates
	$settings_section = 'bpapu_main';
	$page = 'bpapu';
	add_settings_section( $settings_section, sanitize_text_field(esc_attr__( 'Post Types', 'bp-add-post-updates-to-activity' )), 'bpapu_main_section_text_output', $page );

	// Add Post Type selection field to choose which post types to enable for activity updates.
	add_settings_field( $option_name, sanitize_text_field(esc_attr__('Post Types that will be updated to Activity ', 'bp-add-post-updates-to-activity' )), 'bpapu_post_types_input_renderer', $page, $settings_section );

	// Minimum Delay to Repost to Activity Section and Field
	$delay_section = 'bpapu_delay';
	add_settings_section($delay_section, sanitize_text_field(esc_attr__('Repost Delay', 'bp-add-post-updates-to-activity')), 'bpapu_delay_text_output', $page);

	add_settings_field($minimum_delay_option, sanitize_text_field(esc_attr__('Minimum delay to repost the same post update.', 'bp-add-post-updates-to-activity')), 'bpapu_delay_option_renderer', $page, $delay_section);
	
	//Content to Include in Activity update
	$content_section = 'bpapu_content';
	add_settings_section($content_section, sanitize_text_field(esc_attr__('Content to include in update.','bp-add-post-updates-to-activity')), 'bpapu_content_text_output', $page);
	
	add_settings_field($content_option, sanitize_text_field(esc_attr__('Content to be included in activity update','bp-add-post-updates-to-activity')), 'bpapu_content_option_renderer',$page, $content_section);
	}

// Page Information for Post Types support 
function bpapu_main_section_text_output() {
	
	echo '<p>' . sanitize_text_field(esc_attr__( 'You can specify the post types to  post updates to Activity. By default it works on Posts only.', 'bp-add-post-updates-to-activity')) . '</p><p>'. sanitize_text_field(esc_attr__('Note that some post types may already post updates to Activity and selecting them here may result in two updates.', 'bp-add-post-updates-to-activity' )) . '</p>';
	
}

// Page Information for Delay setting 
function bpapu_delay_text_output(){
	
	echo '<p>' . sanitize_text_field(esc_attr__('The minimum delay between posting updates to activity for the same post.', 'bp-add-post-updates-to-activity' )) . '</p>';

}

// Page Information for Content setting 
function bpapu_content_text_output(){
	
	echo '<p>' . sanitize_text_field(esc_attr__('The content that will be included in the activity update can be selected here.', 'bp-add-post-updates-to-activity')) . '</p>';

}

// Create available post types array.
function bpapu_selectable_post_types() {
	
	$post_types = get_post_types( array( 'public' => true ), 'name' );
	
	foreach ( $post_types as $type => $obj ) {
			
		$return[$type] = $obj;
	}
	
	return $return;

}

// foreach ($iced_mochas as $key => $value) { ${"$key"} = is_array( $value ) ? $value : esc_attr($value); }
// Function for saving the selected post types
function bpapu_return_post_types() {
	
	$option = get_option( 'bpapu_post_types', 'default' );
	
	if ( !isset($option) ){
		
		$option=array('default' => 'post');
	
	}

//	foreach ($option as $key => $value) { ${"key"} = is_array( $value ) ? $value : esc_attr($value) ; }
    
	if ( is_string($option) && $option === 'default' ) {
        
		$option = array( 'default' => 'post' );
        add_option( 'bpapu_post_types', $option );
    
	} elseif ( $option === '' ) {
        // For people who want the plugin on, but doing nothing
        $option = array();
    
	}
    
	return apply_filters( 'bpapu_post_types', $option );
}

// Set minimum delay
function bpapu_return_min_delay() {
	
	$minimum_delay = esc_attr(sanitize_text_field(get_option('bpapu_minimum_delay', 1)));
	
	if (!isset($minimum_delay) ) {
		
		$minimum_delay = 1;
	
	}
	
	//foreach ($minimum_delay as $key => $value) { ${"$key"} = is_array( $value ) ? $value : esc_attr($value); }
	
	return $minimum_delay;
}

// Page Input box for the creation of the post-types selections.
function bpapu_post_types_input_renderer() {
	
	$option = bpapu_return_post_types();
	$post_types = bpapu_selectable_post_types();

	foreach ( $post_types as $type => $obj ) {
		
		if ( in_array( $type, $option ) ) {
			
			echo '<input type="checkbox" name="bpapu_post_types[]" value="'.esc_attr($type).'" checked="checked">'.esc_attr($obj->label).'<br>';
		
		} else {
			
			echo '<input type="checkbox" name="bpapu_post_types[]" value="'.esc_attr($type).'">'.esc_attr($obj->label).'<br>';
		
		}
	}
}

// Page Input box for delay selection.
function bpapu_delay_option_renderer(){
	
	$dimensions = bpapu_return_min_delay();
	
	echo '<input type="text" inputmode="numeric" pattern="[0-9]*" id="bpapu_minimum_delay" name="bpapu_minimum_delay", value="'.esc_attr($dimensions).'">'. sanitize_text_field(esc_attr__('Delay (mins) ', 'bp-add-post-updates-to-activity')) . '<br>';
}

// Page Input box for content selection.
function bpapu_content_option_renderer(){
	
	$content_included = Array( 
		'body' 		=> 'Content',
		'excerpt' 	=> 'Excerpt',
		'none' 		=> 'None'
	);
	
	$current_content_setting=esc_attr(sanitize_text_field(get_option('bpapu_content_option')));
	
	echo '<select name="bpapu_content_option">';
	
	foreach ( $content_included as $content_item => $display) {
		
		echo '<option value="'.esc_attr(sanitize_text_field($content_item)).'" name="bpapu_content_option[]" ' . ( $current_content_setting == $content_item ? 'selected="selected"' : '' ).'>'.esc_attr(sanitize_text_field($display)) .'</option>';
	
	}
	
	echo '</select>';

}



