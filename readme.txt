=== BP Add Post Updates to Activity ===
Tags: BuddyPress, Posts, Activity, Updates
Requires at least: 3.0.1
Tested up to: 6.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.6
Contributors: Venutius
Donate Link: paypal.me/GeorgeChaplin
Plugin URI: www.wordpress.org/plugins/add-post-updates-to-activity/
Stable tag: 1.2.2

This plugin adds post updates (revisions) to the BuddyPress Activity Stream, other post-types are selectable, as is the minimum time before re-updating would trigger an activity update.

Also supports Logged-In (LH Logged in Post Status) and Members only (BP Post Status) post statuses. 

It supports custom post types and allows for the Activity content to be selected (Full Content, Excerpt or none.
 
== Description ==
 
By default this plugin allows for standard post updates to be pushed to the activity stream. Other post types can be selected in the plugin settings page (Dashboard>>Settings>>BP Add Post Updates).

You can throttle the minimum re-update time for posts in order to prevent update storms and spam.

You can also choose what content accompanies the update - the full post Content, the Excerpt or just the author and title links.

This plugin requires BuddyPress.

== Upgrade Notice ==

== Installation ==

Option 1.

1. From the Dashboard>>Plugins>>Add New page, search for BP Add Post Updates to Activity.
2. When you have located the plugin, click on "Install" and then "Activate".
3. Visit the Dashboard>>Settings>>BP Add Post Updates page to review and choose your preferred setup.

With the zip file:

Option 2

1. Upzip the plugin into it's directory/file structure
2. Upload BP Add Post Updates to Activity structure to the /wp-content/plugins/ directory.
3. Activate the plugin through the Admin>>Plugins menu.
4. Go to Dashboard>>Settings>>BP Add Post Updates to configure the plugin.

Option 3

1. Go to Admin>>Plugins>>Add New>>Upload page.
2. Select the zip file and choose upload.
3. Activate the plugin.
4. Go to Dashboard>>Settings>>BP Add Post Updates to configure the plugin.
 
== Frequently Asked Questions ==

Q. Does this plugin support Custom Post-Types?

A. Yes, this plugin supports custom post types. These are selected in Settings.

 
= Translators =
 
== Screenshots ==
 
1. screenshot-1.png showing Settings page
2. Screenshot-2.png Showing Activity Update

== Upgrade Notice == 

== Changelog ==

== 1.2.2 =

* 30/07/2024

* Fix: Corrected plugin menu name.
* Fix: Corrected the code to save the delay between updates.
* Security: Changed input type from number, which is not secure, to number only text, which will not allow anything other than a whole number to be entered and is much more secure.

== 1.2.1 ==

* 30/07/2024

* Fix: Updated plugin to allow the delay period to apply to admin. 

== 1.2.0 ==

* 20/07/2024

* Fix: Corrected typo.

== 1.1.5 ==

* 10/02/2021

* Fix: Translation improvements.

== 1.1.4 ==

* 14/04/2019

* Fix: Corrected Text Domain settings.

== 1.1.3 ==

* 20/11/2018

* Fix: Added check to prevent menu items from creating activity items.

== 1.1.2 ==

* 28/04/2018

* Fix: Adjusted activity message content.

== 1.1.1 ==

* 28/04/2018

* Updated: Added new update delay time check to make sure no new posts are published.

== 1.1.0 ==

* 27/04/2018

* Fix: Corrected activity content error.
* Refinement: switched main function to trigger on post_updated.

== 1.0.9 ==

* 26/04/2018

* Fix: Moved main function to trigger on edit_posts.

== 1.0.8 ==

* 26/04/2018

* Fix: corrected GMT issue when checking for update times.

== 1.0.7 ==

* 22/04/2018

* Fix: Activity excerpts now showing correctly.

== 1.0.6 ==

* 15/04//2018

* Added feature whereby activity will be deleted on post deletion.
* Improved error checking to reduce risk of duplicate activity updates.

== 1.0.5 ==

* 15/04/2018

* Updated code for more efficient operation
* Added support for logged in and members only post types.
* Revised Text Domain

== 1.0.4 ==

* Corrected naming error with text domain name.

== 1.0.3 ==

* 31/01/2018

* changed translation text domain name to make it more readable.
* fixed illegal offset error

== 1.0.2 ==

* 30/01/2018

* fixed error with admin delay option on initial install.

== 1.0.1 ==

* fixed error with admin page for first time display - no options set.

== 1.0.0 ==

* Content selection, escaped attributes and translation complete. Updated Readme and Uninstall pages.

== 0.0.2 ==

* Completed most of the basic structure. 28/01/2018

== 0.0.1 ==

* First Version. 21/01/2018
