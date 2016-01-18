<?php 

// I don't understand how to use classes in PHP

		function ca_guest_post_sidebar_menu(){
			add_menu_page( 
						'Guest Postly', 
						'Guest Postly', 
						'manage_options', 
						'guest-post', // This is the slug for the "plugin" top-level page
						'guest_post_menu_page', 
						 'dashicons-smiley',
						 7 ); 
} 

		add_action( 'admin_menu', 'ca_guest_post_sidebar_menu' );


		// html for parent/main admin panel

		function guest_post_menu_page(){

			require_once ( plugin_dir_path(__FILE__) . 'parent_admin.php' );


		}

 ?>