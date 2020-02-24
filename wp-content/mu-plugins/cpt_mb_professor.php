<?php

/**
 * Plugin Name: CPT Professor
 * Description: create professor custom post type
 * Author: Ultime
 */
add_action('init', 'professor_post_type');
function professor_post_type()
{
    register_post_type('professor', array(
        'public' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-universal-access-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'les-professeurs'),
        'menu_position' => 5,
        'labels' => array(
            'name' => 'Professeurs',
            'add_new_item' => 'Ajouter un Professeur',
            'edit_item' => 'Modifier un Professeur',
            'all_items' => 'Tous les Professeurs',
            'singular_name' => 'Professeur'
        )
    ));
}
