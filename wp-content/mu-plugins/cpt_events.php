<?php

// add custom post type
add_action('init', 'event_post_type');
function event_post_type()
{
    register_post_type('event', array(
        'public' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'menu_icon' => 'dashicons-megaphone',
        'has_archive' => true,
        'rewrite' => array('slug' => 'evenemnts'),
        'menu_position' => 5,
        'labels' => array(
            'name' => 'Evenements',
            'add_new_item' => 'Ajouter un Événement',
            'edit_item' => 'Éditer un Événement',
            'all_items' => 'Tous les Événements',
            'singular_name' => 'Événement'
        )
    ));
}
