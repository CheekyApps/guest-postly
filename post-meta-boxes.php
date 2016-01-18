<?php 

/**
 * Adds a box to the main column on the Post and Page edit screens.
 * Here is all the info https://codex.wordpress.org/Function_Reference/add_meta_box 
 */
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_meta_box() {

	$screens = array( 'post', 'page' );

	add_meta_box(
		'myplugin_sectionid',
		__( 'Poster - Project Management', 'myplugin_textdomain' ),
		'myplugin_meta_box_callback',
		$screens, 
		'side'
	);
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_save_meta_box_data', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_my_meta_value_key', true );

	// how to set up the tab menu https://tommcfarlin.com/custom-meta-box-tabs/
	// I am worried this will mess with the currnet categorydiv stuff
?>

<div id="acme-navigation">
	<h2 class="nav-tab-wrapper current">
		<a class="nav-tab nav-tab-active" href="javascript:;">Extended Description</a>
		<a class="nav-tab" href="javascript:;">Related Files</a>
		<a class="nav-tab" href="javascript:;">Similar Posts</a>
	</h2>
</div>


<div id="taxonomy-linkcategory" class="categorydiv">
	<ul id="category-tabs" class="category-tabs">
		<li class="tabs"><a href="#categories-all"><?php _e( 'Notes' ); ?></a></li>
		<li class="hide-if-no-js"><a href="#categories-pop"><?php _e( 'Assign Writer' ); ?></a></li>
		<li class="hide-if-no-js"><a href="#categories-pop"><?php _e( 'Invite Writer' ); ?></a></li>
	</ul>

	<div id="categories-all" class="tabs-panel">
		<ul id="categorychecklist" data-wp-lists="list:category" class="categorychecklist form-no-clear">
			<?php
			if ( isset($link->link_id) )
				wp_link_category_checklist($link->link_id);
			else
				wp_link_category_checklist();
			?>
		</ul>
	</div>

	<div id="categories-pop" class="tabs-panel" style="display: none;">
		<ul id="categorychecklist-pop" class="categorychecklist form-no-clear">
			<?php wp_popular_terms_checklist('link_category'); ?>
		</ul>
	</div>

	<div id="category-adder" class="wp-hidden-children">
		<a id="category-add-toggle" href="#category-add" class="taxonomy-add-new"><?php _e( '+ Add New Category' ); ?></a>
		<p id="link-category-add" class="wp-hidden-child">
			<label class="screen-reader-text" for="newcat"><?php _e( '+ Add New Category' ); ?></label>
			<input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php esc_attr_e( 'New category name' ); ?>" aria-required="true" />
			<input type="button" id="link-category-add-submit" data-wp-lists="add:categorychecklist:link-category-add" class="button" value="<?php esc_attr_e( 'Add' ); ?>" />
			<?php wp_nonce_field( 'add-link-category', '_ajax_nonce', false ); ?>
			<span id="category-ajax-response"></span>
		</p>
	</div>
</div>

<div>
	<p style="text-align: center;">
		<a class="button button-primary button-large" target="_blank" href="http://cheekyapps.com/easy-to-tweet-waiting-list/">Apply Changes</a>
	</p>

	<p style="text-align: center;">
		<a class="button button-primary button-large" target="_blank" href="http://cheekyapps.com/easy-to-tweet-waiting-list/">Upgrade to Pro</a>
	</p>
</div>	
<?php 

// 	echo '<label for="myplugin_new_field">';
// 	_e( 'Description for this field', 'myplugin_textdomain' );
// 	echo '</label> ';
// 	echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
// 
	}

/* When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['myplugin_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );

 ?>