<?php

namespace PC\Primary_Categories;

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_enqueue_scripts', 10 );
add_action( 'add_meta_boxes', __NAMESPACE__ . '\\custom_category_meta_box', 10 );

/**
 * Enqueues the script for handling the primary category select input.
 *
 * @since 0.0.1
 */
function admin_enqueue_scripts() {
	$screen = get_current_screen();

	if ( 'post' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_script( 'pc-primary-category', plugins_url( 'js/admin-primary-category.js', dirname( __FILE__ ) ), array(), null, true );
}

/**
 * Remove the default category meta box, re-add it with a custom callback.
 *
 * @since 0.0.1
 */
function custom_category_meta_box() {
	remove_meta_box( 'categorydiv', 'post', 'side' );
	add_meta_box( 'categorydiv', 'Categories', __NAMESPACE__ . '\\custom_category_meta_box_cb', 'post', 'side' );
}

/**
 * Output the custom category meta box.
 *
 * @since 0.0.1
 *
 * @param WP_Post $post The current post.
 * @param array   $box  Metabox id, title, callback, and args.
 */
function custom_category_meta_box_cb( $post, $box ) {
	// Define the box taxonomy as `category`.
	$box['args']['taxonomy'] = 'category';

	// Display the default categories form field.
	post_categories_meta_box( $post, $box );

	wp_nonce_field( 'pc_primary_category', 'pc_primary_category_nonce' );
	?>
	<p class="description">Please select all categories before designating the primary category.</p>
	<select name="_pc_primary_category" class="widefat" disabled>
		<option value="">Set primary category</option>
	</select>
	<?php
}
