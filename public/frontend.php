<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX Filter Request
 */
function fkv_handle_search()
{
    check_ajax_referer('fkv_search_nonce', 'nonce');

    $args = array(
        'post_type' => 'first_content',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => isset($_POST['paged']) ? intval($_POST['paged']) : 1,
    );

    // Search
    if (!empty($_POST['search'])) {
        $args['s'] = sanitize_text_field($_POST['search']);
    }

    // Tax Queries
    $tax_query = array('relation' => 'AND');

    $filters = ['fkv_category', 'fkv_year', 'fkv_team', 'fkv_award'];
    foreach ($filters as $tax) {
        if (!empty($_POST[$tax])) {
            $tax_query[] = array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => sanitize_text_field($_POST[$tax]),
            );
        }
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            fkv_get_template_part_card();
        }
        // Pagination logic could be added here or sending max_pages back in JSON
    } else {
        echo '<p class="fkv-no-results">No entries found.</p>';
    }
    $html = ob_get_clean();

    wp_send_json_success(array(
        'html' => $html,
        'max_pages' => $query->max_num_pages
    ));
}
add_action('wp_ajax_fkv_search', 'fkv_handle_search');
add_action('wp_ajax_nopriv_fkv_search', 'fkv_handle_search');


/**
 * Helper: Render a Single Card
 */
function fkv_get_template_part_card()
{
    $pdf_url = get_post_meta(get_the_ID(), '_fkv_pdf_url', true);
    $has_pdf = !empty($pdf_url);
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: plugin_dir_url(__FILE__) . '../assets/placeholder.jpg'; // Placeholder fallback if needed
    // If no placeholder image exists, use CSS fallback or simple div

    $terms_cat = get_the_terms(get_the_ID(), 'fkv_category');
    $cat_name = $terms_cat && !is_wp_error($terms_cat) ? $terms_cat[0]->name : '';

    ?>
    <div class="fkv-card">
        <div class="fkv-card-thumb" style="background-image: url('<?php echo esc_url($thumb); ?>');">
            <?php if ($cat_name): ?><span class="fkv-badge">
                    <?php echo esc_html($cat_name); ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="fkv-card-body">
            <h3 class="fkv-card-title">
                <?php the_title(); ?>
            </h3>
            <div class="fkv-card-meta">
                <?php
                $year_terms = get_the_terms(get_the_ID(), 'fkv_year');
                if ($year_terms)
                    echo '<span class="fkv-meta-item icon-calendar">' . esc_html($year_terms[0]->name) . '</span>';
                ?>
            </div>
            <div class="fkv-card-actions">
                <?php if ($has_pdf): ?>
                    <button class="fkv-btn-view" data-pdf="<?php echo esc_url($pdf_url); ?>"
                        data-title="<?php echo esc_attr(get_the_title()); ?>">
                        View PDF
                    </button>
                    <a href="<?php echo esc_url($pdf_url); ?>" class="fkv-btn-download" download>
                        <span class="dashicons dashicons-download"></span>
                    </a>
                <?php else: ?>
                    <span class="fkv-no-pdf">No PDF</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Main Render Function
 */
function fkv_render_vault($atts)
{
    // Enqueue scripts/styles if not already
    wp_enqueue_style('fkv-style');
    wp_enqueue_script('fkv-script');

    $initial_category = isset($atts['category_slug']) ? $atts['category_slug'] : '';

    // Build Filters
    $taxonomies = [
        'fkv_category' => 'Category',
        'fkv_year' => 'Year',
        'fkv_team' => 'Team',
        'fkv_award' => 'Award'
    ];

    ob_start();
    ?>
    <div class="fkv-wrapper" id="fkv-wrapper">
        <!-- Controls -->
        <div class="fkv-controls">
            <div class="fkv-search-box">
                <input type="text" id="fkv-search-input" placeholder="Search archive..." />
            </div>

            <div class="fkv-filters">
                <?php foreach ($taxonomies as $slug => $label): ?>
                    <select class="fkv-filter-select" data-tax="<?php echo esc_attr($slug); ?>">
                        <option value="">
                            <?php echo esc_html("All $label"); ?>s
                        </option>
                        <?php
                        $terms = get_terms(['taxonomy' => $slug, 'hide_empty' => true]);
                        foreach ($terms as $term) {
                            $selected = ($slug === 'fkv_category' && $term->slug === $initial_category) ? 'selected' : '';
                            echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                        }
                        ?>
                    </select>
                <?php endforeach; ?>
                <button id="fkv-reset-btn">Reset</button>
                <button id="fkv-mode-toggle">🌙</button>
            </div>
        </div>

        <!-- Grid -->
        <div class="fkv-grid" id="fkv-grid">
            <!-- Content loaded via JS or initial PHP loop -->
            <?php
            // Initial Load
            $args = array(
                'post_type' => 'first_content',
                'posts_per_page' => 12,
                'post_status' => 'publish'
            );
            if ($initial_category) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'fkv_category',
                        'field' => 'slug',
                        'terms' => $initial_category
                    ]
                ];
            }
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    fkv_get_template_part_card();
                }
            } else {
                echo '<p>No content found.</p>';
            }
            wp_reset_postdata();
            ?>
        </div>

        <!-- Pagination -->
        <div class="fkv-pagination">
            <button id="fkv-load-more" data-page="1">Load More</button>
        </div>

        <!-- PDF Modal -->
        <div id="fkv-modal" class="fkv-modal">
            <div class="fkv-modal-content">
                <span class="fkv-close">&times;</span>
                <h3 id="fkv-modal-title"></h3>
                <iframe id="fkv-modal-frame" src="" width="100%" height="600px"></iframe>
            </div>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
