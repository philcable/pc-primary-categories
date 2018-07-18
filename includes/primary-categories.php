<?php

namespace PC\Primary_Categories;

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_enqueue_scripts', 10 );
add_action( 'add_meta_boxes', __NAMESPACE__ . '\\custom_category_meta_box', 10 );
add_action( 'save_post', __NAMESPACE__ . '\\save_post', 10, 2 );

/**
 * Provides the post types for which to enable the primary category feature.
 *
 * @since 0.0.1
 */
function post_types() {
	$default = array( 'post' );

	return apply_filters( 'pc_primary_categories_post_types', $default );
}

/**
 * Enqueues the script for handling the primary category select input.
 *
 * @since 0.0.1
 */
function admin_enqueue_scripts() {
	$screen = get_current_screen();

	if ( ! in_array( $screen->post_type, post_types(), true ) ) {
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
	remove_meta_box( 'categorydiv', post_types(), 'side' );
	add_meta_box( 'categorydiv', 'Categories', __NAMESPACE__ . '\\custom_category_meta_box_cb', post_types(), 'side' );
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

	$post_categories = wp_get_post_categories( $post->ID, array( 'fields' => 'id=>name' ) );

	$primary_category = get_post_meta( $post->ID, '_pc_primary_category', true );
	?>
	<p class="description">Please select all categories before designating the primary category.</p>
	<select name="_pc_primary_category" class="widefat" disabled>
		<option value="">Set primary category</option>
		<?php
		if ( ! empty( $post_categories ) ) {
			foreach ( $post_categories as $category_id => $category_name ) {
				?>
				<option value="<?php echo absint( $category_id ); ?>" <?php selected( $category_id, $primary_category ); ?>><?php echo esc_html( $category_name ); ?></option>
				<?php
			}
		}
		?>
	</select>
	<?php
}

/**
 * Saves data associated with a directory page.
 *
 * @since 0.0.1
 *
 * @param int $post_id Post ID.
 */
function save_post( $post_id ) {
	if ( ! isset( $_POST['pc_primary_category_nonce'] ) || ! wp_verify_nonce( $_POST['pc_primary_category_nonce'], 'pc_primary_category' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_pc_primary_category'] ) ) {
		$primary_category_id = absint( $_POST['_pc_primary_category'] );

		if ( ! is_null( get_category( $primary_category_id ) ) ) {
			update_post_meta( $post_id, '_pc_primary_category', $primary_category_id );
		}
	} else {
		delete_post_meta( $post_id, '_pc_primary_category' );
	}
}
