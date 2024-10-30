<?php
// If uninstall was not called from WordPress, exit!
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;

// Cleaning up
delete_option( 'bpapu_post_types' );
delete_option( 'bpapu_minimum_delay' );
delete_option( 'bpapu_content_option' );
