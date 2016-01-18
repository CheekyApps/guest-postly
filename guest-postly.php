<?php 

/*
Plugin Name: Guest Postly - A Project Management Plugin by Cheeky Apps
Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Manage guest posts, writers, posts, pages with this powerful Project Management plugin. 
Version:     1.0
Author:      scottmoses, CheekyApps
Author URI:  http://URI_Of_The_Plugin_Author // do thiss........
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: guest-postly
*/


// might have to change the name. This is really a content mangament plugin.

//make a menu page, for the side bar



// figure out how to add a widget to the side bar of any wordpress post. 

if ( ! defined('ABSPATH')){
	exit;
}

require_once ( plugin_dir_path(__FILE__) . 'admin/main_admin_menu.php' );
require_once ( plugin_dir_path(__FILE__) . 'post-meta-boxes.php' );


 ?>