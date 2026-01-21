<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Shortcodes
 */
// [first_vault_home]
add_shortcode('first_vault_home', function ($atts) {
    return fkv_render_vault(array_merge($atts ? $atts : [], ['type' => 'all']));
});

// [first_vault_ftc]
add_shortcode('first_vault_ftc', function ($atts) {
    return fkv_render_vault(array_merge($atts ? $atts : [], ['category_slug' => 'ftc-manual'])); // Example slug, adjustable
});

// [first_vault_deans]
add_shortcode('first_vault_deans', function ($atts) {
    return fkv_render_vault(array_merge($atts ? $atts : [], ['category_slug' => 'deans-list-essay']));
});

// [first_vault_team]
add_shortcode('first_vault_team', function ($atts) {
    $atts = shortcode_atts(array(
        'id' => '', // Team ID/Slug
    ), $atts, 'first_vault_team');
    return fkv_render_vault(array_merge([], ['team_slug' => $atts['id']]));
});
