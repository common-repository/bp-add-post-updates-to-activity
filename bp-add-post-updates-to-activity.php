<?php
/*
* Plugin Name: BP Add Post Updates to Activity
* Plugin URI: https://buddyuser.com/plugin-bp-add-post-updates-to-activity
* Description: This plugin adds post updates to the BuddyPress Activity Stream
* Author: Venutius
* Version: 1.2.2
* Donate Link: paypal.me/GeorgeChaplin
* Text Domain: bp-add-post-updates-to-activity
* Author URI: https://www.buddyuser.com
* @package    bp-add-post-updates-to-activity
* @copyright  Copyright (c) 2024, George Chaplin, however the license allows you to copy and modify at will. If you are able to make money with solutions that include this plugin a few beers would be appreciated ;)
* @link       https://buddyuser.com
* @license    https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* Domain Path: /langs
*/
 
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if(!defined('ABSPATH')) {
	exit;
}

require_once ( plugin_dir_path(__FILE__) . '/inc/bpapu-add-activity.php' );
require_once ( plugin_dir_path(__FILE__) . '/inc/bpapu-admin-options.php' );

// Localization
function bpu_bpapu_action_init() {

	if ( file_exists( dirname( __FILE__ ).'/langs/bp-add-post-updates-to-activity-' . get_locale() . 'mo' ) ) {
		load_plugin_textdomain('bp-add-post-updates-to-activity', dirname( __FILE__ ).'/bp-add-post-updates-to-activity-' . get_locale() . 'mo' );
	}
}
 
add_action('init', 'bpu_bpapu_action_init');

// Create settings action link
function bpapu_add_action_links( $links ) {
	
	$review_link = '<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/bp-add-activity-updates-to-activity?filter=5#pages" title="' . 
		sanitize_text_field(esc_attr__('If you like it, please review the plugin', 'bp-add-post-updates-to-activity')) . '">' . sanitize_text_field(esc_attr__('Review the plugin', 'bp-add-post-updates-to-activity')) . 
		'</a>';

	$url = get_admin_url(null, 'options-general.php?page=bpapu');
 
	$links[] = '<a href="'. esc_url($url) .'">'.sanitize_text_field(esc_attr__('Settings','bp-add-post-updates-to-activity')).'</a>';
	$links[] = $review_link;
	
	return $links;

}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bpapu_add_action_links' );
