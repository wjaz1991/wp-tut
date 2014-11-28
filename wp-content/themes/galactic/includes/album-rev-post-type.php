<?php
add_action('init', 'album_reviews_register');

function album_reviews_register() {
    $args = array(
        'label' => 'Album Reviews',
        'singular_label' => 'Album Review',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'rewrite' => array(
            'slug' => 'album_reviews',
            'with_front' => false
        ),
    );
    
    register_post_type('album-reviews', $args);
    
    register_taxonomy('album-type', array('album-reviews'), array(
        'hierarchical' => true,
        'label' => 'Album Types',
        'singular_label' => 'Album Type',
        'rewrite' => true,
        'slug' => 'album-type',
    ));
    
    add_action('admin_init', 'album_reviews_add_meta');
    
    function album_reviews_add_meta() {
        add_meta_box('album-review-meta', 'Cover image', 'album_review_meta_display', 'album-reviews', 'side', 'high');
    }
    
    function album_review_meta_display() {
        global $post;
        
        $artworkURL = get_post_meta($post->ID, 'artwork-url', true);
        $artworkTitle = get_post_meta($post->ID, 'artwork-title', true);
        $artworkAlt = get_post_meta($post->ID, 'artwork-alt', true);
        ?>
        <div class="artwork-meta">
            <label>Artwork URL: <br>
                <input type="text" name="artwork-url" id="artwork-url" value="<?php echo esc_url($artworkURL); ?>">
            </label><br>
            <label>Artwork title: <br>
                <input type="text" name="artwork-title" id="artwork-title" value="<?php echo esc_attr($artworkTitle); ?>">
            </label><br>
            <label>Artwork alt text: <br>
                <input type="text" name="artwork-alt" id="artwork-alt" value="<?php echo esc_attr($artworkAlt); ?>">
            </label>
        </div>
        
        <a title="Set album artwork" href="javascript:;" id="set-album-artwork">Set album artwork</a>
        <a title="Remove album artwork" href="javascript:;" id="remove-album-artwork">Remove album artwork</a>
        <div style="display: none;" id="album-artwork-preview">
            <img style="width: 100%; height: auto;" src="<?php echo esc_url($artworkURL); ?>" alt="<?php echo esc_attr($artworkAlt); ?>" title="<?php echo esc_attr($artworkTitle); ?>">
        </div>
        <?php
    }
}

add_action('admin_enqueue_scripts', 'enqueue_scripts');
function enqueue_scripts() {
    wp_enqueue_media();
        
    wp_enqueue_script('media-metaboxes', SCRIPTS . '/media-upload-metaboxes.js', array('jquery'));
}

add_action('save_post', 'save_post_artwork', 10, 2);
function save_post_artwork($post_id, $post) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    if(isset($_POST['artwork-url'])) {
        update_post_meta($post_id, 'artwork-url', sanitize_text_field($_POST['artwork-url']));
    }
    
    if(isset($_POST['artwork-title'])) {
        update_post_meta($post_id, 'artwork-title', sanitize_text_field($_POST['artwork-title']));
    }
    
    if(isset($_POST['artwork-alt'])) {
        update_post_meta($post_id, 'artwork-alt', sanitize_text_field($_POST['artwork-alt']));
    }
}