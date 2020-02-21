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

    // register nav menu
    register_nav_menus(array(
        'primary_menu' => __('Menu Principal', 'text_domain')
    ));
}
function webp_file_and_ext($mime, $file, $filename, $mimes)
{

    $wp_filetype = wp_check_filetype($filename, $mimes);
    if (in_array($wp_filetype['ext'], ['webp'])) {
        $mime['ext']  = true;
        $mime['type'] = true;
    }

    return $mime;
}
add_filter('wp_check_filetype_and_ext', 'webp_file_and_ext', 10, 4);

function add_webp_mime_type($mimes)
{
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'add_webp_mime_type');
