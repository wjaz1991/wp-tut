<?php
//SOME GLOBAL VARIABLES
define('TEMPPATH', get_bloginfo('stylesheet_directory'));
define('IMAGES', TEMPPATH . '/images');
define('SCRIPTS', TEMPPATH . '/js');

//ADDING SOME THEME FEATURES
add_action('init', 'add_theme_features');
function add_theme_features()
{
    add_theme_support('post-thumbnails');
    //if (function_exists('register_nav_menus')) {
        register_nav_menu('main', 'Main Navigation');
    //}

    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Primary Sidebar',
            'id' => 'sidebar-primary',
            'description' => 'The primary sidebar',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget_title">',
            'after_title' => '</h3>'
        ));
    }
}

if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'enqueue_theme_scripts', 11);
}

function enqueue_theme_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}

add_filter('excerpt_more', 'custom_excerpt_text');
function custom_excerpt_text($more) {
    return '...';
}

//registering post type for album reviews
require_once('includes/album-rev-post-type.php');