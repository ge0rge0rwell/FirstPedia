<?php
/**
 * Plugin Name: FIRST Knowledge Vault
 * Plugin URI:  https://example.com/first-knowledge-vault
 * Description: A professional FTC Knowledge Archive and FRC Dean’s List Essay Library.
 * Version:     1.0.0
 * Author:      Antigravity
 * Text Domain: first-knowledge-vault
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Constants
define( 'FKV_VERSION', '1.0.0' );
define( 'FKV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FKV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include Core Files
require_once FKV_PLUGIN_DIR . 'includes/post-types.php';
require_once FKV_PLUGIN_DIR . 'includes/taxonomies.php';
require_once FKV_PLUGIN_DIR . 'includes/shortcodes.php';
require_once FKV_PLUGIN_DIR . 'admin/admin-ui.php';
require_once FKV_PLUGIN_DIR . 'public/frontend.php';

/**
 * Enqueue Scripts and Styles
 */
function fkv_enqueue_scripts() {
	// Register and Enqueue CSS
	wp_enqueue_style( 
		'fkv-style', 
		FKV_PLUGIN_URL . 'public/style.css', 
		array(), 
		FKV_VERSION 
	);

	// Register and Enqueue JS
	wp_enqueue_script( 
		'fkv-script', 
		FKV_PLUGIN_URL . 'public/vault.js', 
		array( 'jquery' ), 
		FKV_VERSION, 
		true 
	);

	// Localization for Ajax
	wp_localize_script( 'fkv-script', 'fkvData', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'fkv_search_nonce' )
	));
}
add_action( 'wp_enqueue_scripts', 'fkv_enqueue_scripts' );

/**
 * Admin Enqueue (Optional, for admin styling if needed)
 */
function fkv_admin_enqueue_scripts() {
	// Add admin-specific styles here if needed.
}
add_action( 'admin_enqueue_scripts', 'fkv_admin_enqueue_scripts' );
