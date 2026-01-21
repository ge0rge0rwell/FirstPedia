<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Metabox for PDF Upload/Link
 */
function fkv_add_meta_boxes()
{
    add_meta_box(
        'fkv_pdf_meta',
        __('Vault PDF File', 'first-knowledge-vault'),
        'fkv_pdf_meta_callback',
        'first_content',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'fkv_add_meta_boxes');

/**
 * Metabox Callback
 */
function fkv_pdf_meta_callback($post)
{
    wp_nonce_field('fkv_save_pdf_data', 'fkv_pdf_meta_nonce');
    $value = get_post_meta($post->ID, '_fkv_pdf_url', true);

    echo '<p>';
    echo '<label for="fkv_pdf_url">' . __('PDF URL', 'first-knowledge-vault') . '</label>';
    echo '<input type="text" id="fkv_pdf_url" name="fkv_pdf_url" value="' . esc_attr($value) . '" class="widefat" placeholder="https://..." />';
    echo '<p class="description">' . __('Enter the URL of the PDF or upload it to Media Library and paste the link here.', 'first-knowledge-vault') . '</p>';
    echo '</p>';

    // Simple Upload Button Integration (basic)
    echo '<button type="button" class="button" id="fkv_upload_pdf_btn">' . __('Select from Media Library', 'first-knowledge-vault') . '</button>';

    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('#fkv_upload_pdf_btn').click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload PDF',
                    multiple: false
                }).open()
                    .on('select', function (e) {
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        $('#fkv_pdf_url').val(image_url);
                    });
            });
        });
    </script>
    <?php
}

/**
 * Save Metabox Data
 */
function fkv_save_pdf_data($post_id)
{
    if (!isset($_POST['fkv_pdf_meta_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['fkv_pdf_meta_nonce'], 'fkv_save_pdf_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['fkv_pdf_url'])) {
        $my_data = sanitize_text_field($_POST['fkv_pdf_url']);
        update_post_meta($post_id, '_fkv_pdf_url', $my_data);
    }
}
add_action('save_post', 'fkv_save_pdf_data');
