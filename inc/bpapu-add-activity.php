<?php

if(!defined('ABSPATH')) {
	exit;
}

//This section vets the type of save operation and publishes the activity update for qualifying posts.

//Function to create activity update when a published post is updated.
function bpu_buddypress_edit_post($post_id) {

	
	// if activity module is not active, why bother.
	if ( ! bp_is_active( 'activity' ) ) {
		
		return false;
	
	}

	if ( wp_is_post_revision( $post_id ) ) {
		
		return;
	
	}

	//Check for none supported post-types	
	$post = get_post($post_id);
	$post_type = $post->post_type;
	
	if ( $post_type == 'nav_menu_item' ) {
		
		return false;
		
	}
	
	$supported_types = get_option('bpapu_post_types');
	
	if ( $supported_types != false ) {
		
		$is_update_post_type = in_array( $post_type, $supported_types );
	
	} else if ( $post_type == 'post' ) {
		
		$is_update_post_type = true;
	
	} else {
		
		return false;
	
	}
	
	//Need check for publish post status
	$post_status = $post->post_status;
	
	if ( 'publish' != $post_status && 'members_only' != $post_status && 'logged_in' != $post_status ) {
		
		return;
	
	}
	
	//check it's not a new post
    
	if( $post->post_modified_gmt == $post->post_date_gmt ){
		
		return false;
    
	}

	// Calculate the time from the last update for that post.
	$update_delay_setting = get_option('bpapu_minimum_delay');
	
	if ( $update_delay_setting['delay'] != false ) {
		
		$update_delay = $update_delay_setting['delay'];

	} else {
		
		$update_delay = 20;
	
	}
	
	if ( $update_delay < 1 )  {
		
		$update_delay = 1;
	
	}
	
	$update_delay = $update_delay * 60;
	$current_time = current_time( 'timestamp', 1 );
	$last_updated = get_post_modified_time( 'G', 1 );
	$published = strtotime( $post->post_date_gmt );
	$time_from_last_update = $current_time - $last_updated;
	$time_from_creation = $current_time - $published;
	
	if ( $time_from_last_update <= $update_delay || $time_from_creation <= $update_delay ) {
		
		return false;
	
	}

	// Update Activity feed with post details
    global $bp, $user_id;
	$title = $post->post_title;
	
	//bp_get_displayed_user_fullname() - for logged in usernames - Could be used to check author and editor
	//bp_core_get_user_displayname($post->post_author)
    
	$user_fullname  = esc_attr(sanitize_text_field(bp_core_get_user_displayname($post->post_author)));
	$user_profile_url = esc_attr(sanitize_text_field(bp_members_get_user_url( $post->post_author )));
	$post_link = esc_url(get_permalink($post_id));

	// Check that author name is valid.
	if ( $user_fullname == '' ) {
		
		return false;
	
	}
	
	$content_included = get_option('bpapu_content_option');
	
	if( !isset($content_included )) {
		
		$content_type = 'excerpt';
	
	} else {
		
		$content_type = $content_included;
		
	}
	
	if ( $content_type == 'excerpt') {
		
		 setup_postdata( $post );
		 $content = get_the_excerpt($post);
	
	}
	
	If ( $content_type == 'body' ) {
		
		$content = $post->post_content;
	
	}
	
	If ( $content_type == 'none' ) {
		
		$content = '';
	
	}
		 
	//Create BP Activity
	
	$bp_activity_id = bp_activity_add(array(
		'action' 			=> sprintf('<a href="' . esc_html($user_profile_url) . '" >' . esc_attr($user_fullname).'</a> ' . esc_attr_x('updated','bp-add-post-updates-to-activity') . ' \'' . '<a href="' . $post_link . '" >' . esc_attr(sanitize_text_field(get_the_title($post_id))) . '</a> \'', '<a href="' . esc_url($bp->loggedin_user->domain) . 
			'">' . esc_attr(sanitize_text_field($bp->loggedin_user->fullname)) . '</a>'),
		'content' 			=> $content,
		'component' 		=> 'blogs',
		'type' 				=> 'activity_update',
		'primary_link' 		=> $post_link,
		'user_id' 			=> $post->post_author,
		'item_id' 			=> get_current_blog_id(),
		'secondary_id'		=> $post->ID
     ));
	 
	// Add this update to the "latest update" usermeta so it can be fetched anywhere.
	bp_update_user_meta( bp_core_get_user_displayname($post->post_author), 'bp_latest_update', array(
		'id'      			=> $bp_activity_id,
		'content' 			=> $content
	) );
}

add_action('post_updated', 'bpu_buddypress_edit_post');

function bpu_delete_activity($post_id) {
	
	// Removes the activity on post deletion
	$item_id = esc_attr(sanitize_text_field($post_id));
	$post = get_post( $post_id );
	
	// Get the Activity id
	$args = array(
		'item_id'           => $item_id,
		'user_id'			=> $post->post_author
	);

	$activity_id = bp_activity_get_activity_id( $args );


	//Delete Activity
	$args = array(
		'id'                => $activity_id,
		'item_id'           => $item_id
	);

	bp_activity_delete( $args );

}

add_action( 'delete_post', 'bpu_delete_activity' );