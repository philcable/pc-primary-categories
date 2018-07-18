<?php

namespace PC\Primary_Categories;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\\custom_category_meta_box', 10 );

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
