<?php



// wpu theme setup
add_action('after_setup_theme', 'wpu_setup_theme');
function wpu_setup_theme()
{
    // enqueue styles
    wp_enqueue_style('main-css', get_stylesheet_uri());

    //enqueue scripts
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), 'v1', true);


    // add theme support
    add_theme_support('post-thumbnails');

    // en
}
