<?php
/*
Plugin Name: Primary Categories
Version: 0.0.1
Description: Allows users to designate a primary category for posts.
Author: philcable
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// This plugin uses namespaces and requires PHP 5.3 or greater.
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>WSU People Directory requires PHP 5.3 to function properly. Please upgrade PHP or deactivate the plugin.</p></div>';
	} );

	return;
} else {
	add_action( 'after_setup_theme', 'pc_primary_categories' );

	/**
	 * Start things up.
	 */
	function pc_primary_categories() {
		include_once __DIR__ . '/includes/primary-categories.php';
	}
}
