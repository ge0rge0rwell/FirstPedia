<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register 'first_content' Custom Post Type
 */
/**
 * Register 'fkv_portfolio' and 'fkv_tip' Custom Post Types
 */
function fkv_register_post_types()
{
    // --- Portfolio Post Type ---
    $portfolio_labels = array(
        'name'                  => _x('Portfolios', 'Post Type General Name', 'first-knowledge-vault'),
        'singular_name'         => _x('Portfolio', 'Post Type Singular Name', 'first-knowledge-vault'),
        'menu_name'             => __('Portfolios', 'first-knowledge-vault'),
        'name_admin_bar'        => __('Portfolio', 'first-knowledge-vault'),
        'archives'              => __('Portfolio Archives', 'first-knowledge-vault'),
        'attributes'            => __('Portfolio Attributes', 'first-knowledge-vault'),
        'parent_item_colon'     => __('Parent Portfolio:', 'first-knowledge-vault'),
        'all_items'             => __('All Portfolios', 'first-knowledge-vault'),
        'add_new_item'          => __('Add New Portfolio', 'first-knowledge-vault'),
        'add_new'               => __('Add New', 'first-knowledge-vault'),
        'new_item'              => __('New Portfolio', 'first-knowledge-vault'),
        'edit_item'             => __('Edit Portfolio', 'first-knowledge-vault'),
        'update_item'           => __('Update Portfolio', 'first-knowledge-vault'),
        'view_item'             => __('View Portfolio', 'first-knowledge-vault'),
        'view_items'            => __('View Portfolios', 'first-knowledge-vault'),
        'search_items'          => __('Search Portfolio', 'first-knowledge-vault'),
        'not_found'             => __('Not found', 'first-knowledge-vault'),
        'not_found_in_trash'    => __('Not found in Trash', 'first-knowledge-vault'),
        'featured_image'        => __('Cover Image', 'first-knowledge-vault'),
        'set_featured_image'    => __('Set cover image', 'first-knowledge-vault'),
        'remove_featured_image' => __('Remove cover image', 'first-knowledge-vault'),
        'use_featured_image'    => __('Use as cover image', 'first-knowledge-vault'),
    );
    $portfolio_args = array(
        'label'                 => __('Portfolio', 'first-knowledge-vault'),
        'description'           => __('FTC Portfolios', 'first-knowledge-vault'),
        'labels'                => $portfolio_labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
        'taxonomies'            => array('fkv_year', 'fkv_team', 'fkv_award'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('fkv_portfolio', $portfolio_args);

    // --- Tips Post Type ---
    $tip_labels = array(
        'name'                  => _x('Tips', 'Post Type General Name', 'first-knowledge-vault'),
        'singular_name'         => _x('Tip', 'Post Type Singular Name', 'first-knowledge-vault'),
        'menu_name'             => __('Tips', 'first-knowledge-vault'),
        'name_admin_bar'        => __('Tip', 'first-knowledge-vault'),
        'archives'              => __('Tip Archives', 'first-knowledge-vault'),
        'attributes'            => __('Tip Attributes', 'first-knowledge-vault'),
        'parent_item_colon'     => __('Parent Tip:', 'first-knowledge-vault'),
        'all_items'             => __('All Tips', 'first-knowledge-vault'),
        'add_new_item'          => __('Add New Tip', 'first-knowledge-vault'),
        'add_new'               => __('Add New', 'first-knowledge-vault'),
        'new_item'              => __('New Tip', 'first-knowledge-vault'),
        'edit_item'             => __('Edit Tip', 'first-knowledge-vault'),
        'update_item'           => __('Update Tip', 'first-knowledge-vault'),
        'view_item'             => __('View Tip', 'first-knowledge-vault'),
        'view_items'            => __('View Tips', 'first-knowledge-vault'),
        'search_items'          => __('Search Tip', 'first-knowledge-vault'),
        'not_found'             => __('Not found', 'first-knowledge-vault'),
        'not_found_in_trash'    => __('Not found in Trash', 'first-knowledge-vault'),
        'featured_image'        => __('Cover Image', 'first-knowledge-vault'),
        'set_featured_image'    => __('Set cover image', 'first-knowledge-vault'),
        'remove_featured_image' => __('Remove cover image', 'first-knowledge-vault'),
        'use_featured_image'    => __('Use as cover image', 'first-knowledge-vault'),
    );
    $tip_args = array(
        'label'                 => __('Tip', 'first-knowledge-vault'),
        'description'           => __('General Info and Tips', 'first-knowledge-vault'),
        'labels'                => $tip_labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array('fkv_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-lightbulb',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('fkv_tip', $tip_args);
}
add_action('init', 'fkv_register_post_types', 0);
