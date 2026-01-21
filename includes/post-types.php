<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register 'first_content' Custom Post Type
 */
function fkv_register_post_type()
{
    $labels = array(
        'name' => _x('Knowledge Vault', 'Post Type General Name', 'first-knowledge-vault'),
        'singular_name' => _x('Vault Entry', 'Post Type Singular Name', 'first-knowledge-vault'),
        'menu_name' => __('FIRST Knowledge Vault', 'first-knowledge-vault'),
        'name_admin_bar' => __('Vault Entry', 'first-knowledge-vault'),
        'archives' => __('Vault Archives', 'first-knowledge-vault'),
        'attributes' => __('Item Attributes', 'first-knowledge-vault'),
        'parent_item_colon' => __('Parent Item:', 'first-knowledge-vault'),
        'all_items' => __('All Entries', 'first-knowledge-vault'),
        'add_new_item' => __('Add New Entry', 'first-knowledge-vault'),
        'add_new' => __('Add New', 'first-knowledge-vault'),
        'new_item' => __('New Entry', 'first-knowledge-vault'),
        'edit_item' => __('Edit Entry', 'first-knowledge-vault'),
        'update_item' => __('Update Entry', 'first-knowledge-vault'),
        'view_item' => __('View Entry', 'first-knowledge-vault'),
        'view_items' => __('View Entries', 'first-knowledge-vault'),
        'search_items' => __('Search Entry', 'first-knowledge-vault'),
        'not_found' => __('Not found', 'first-knowledge-vault'),
        'not_found_in_trash' => __('Not found in Trash', 'first-knowledge-vault'),
        'featured_image' => __('Cover Image', 'first-knowledge-vault'),
        'set_featured_image' => __('Set cover image', 'first-knowledge-vault'),
        'remove_featured_image' => __('Remove cover image', 'first-knowledge-vault'),
        'use_featured_image' => __('Use as cover image', 'first-knowledge-vault'),
        'insert_into_item' => __('Insert into item', 'first-knowledge-vault'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'first-knowledge-vault'),
        'items_list' => __('Items list', 'first-knowledge-vault'),
        'items_list_navigation' => __('Items list navigation', 'first-knowledge-vault'),
        'filter_items_list' => __('Filter items list', 'first-knowledge-vault'),
    );
    $args = array(
        'label' => __('Vault Entry', 'first-knowledge-vault'),
        'description' => __('Content for the FIRST Knowledge Vault', 'first-knowledge-vault'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'), // 'custom-fields' for PDF Link handled manually or via metabox
        'taxonomies' => array('fkv_category', 'fkv_year', 'fkv_team', 'fkv_award'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true, // Top level menu
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book-alt',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Enable Gutenberg and REST API
    );
    register_post_type('first_content', $args);
}
add_action('init', 'fkv_register_post_type', 0);
