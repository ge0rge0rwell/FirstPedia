<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Taxonomies
 */
function fkv_register_taxonomies()
{

    // Taxonomy: Category (FTC Manual, Strategy, etc.)
    register_taxonomy('fkv_category', array('fkv_tip'), array(
        'labels' => array(
            'name' => 'FKV Categories',
            'singular_name' => 'FKV Category',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fkv-category'),
        'show_in_rest' => true,
    ));

    // Taxonomy: Year
    register_taxonomy('fkv_year', array('fkv_portfolio'), array(
        'labels' => array(
            'name' => 'Years',
            'singular_name' => 'Year',
            'menu_name' => 'Years',
        ),
        'hierarchical' => false, // Flat tags style usually for years, but hierarchical allows checkbox selection which is nicer for "one year"
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fkv-year'),
        'show_in_rest' => true,
    ));

    // Taxonomy: Team
    register_taxonomy('fkv_team', array('fkv_portfolio'), array(
        'labels' => array(
            'name' => 'Teams',
            'singular_name' => 'Team',
            'menu_name' => 'Teams',
        ),
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fkv-team'),
        'show_in_rest' => true,
    ));

    // Taxonomy: Award Type
    register_taxonomy('fkv_award', array('fkv_portfolio'), array(
        'labels' => array(
            'name' => 'Awards',
            'singular_name' => 'Award',
            'menu_name' => 'Awards',
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fkv-award'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'fkv_register_taxonomies', 0);
