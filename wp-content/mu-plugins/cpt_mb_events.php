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
abstract class WPU_Event_Date_Meta_Box
{
    public static function add()
    {
        add_meta_box(
            'event_date',          // Unique ID
            "Date", // Box title
            [self::class, 'html'],   // Content callback, must be of type callable
            'event'                 // Post type
        );
    }

    public static function save($post_id)
    {
        if (array_key_exists('event_date', $_POST)) {
            update_post_meta(
                $post_id,
                'event_date',
                $_POST['event_date']
            );
        }
        if (!array_key_exists('event_date', $_POST)) {
            add_post_meta(
                $post_id,
                'event_date',
                $_POST['event_date']
            );
        }
    }

    public static function html($post)
    {
        $value = get_post_meta($post->ID, 'event_date', true);
?>
        <label for="event_date" style="display:block;margin-bottom:1rem;">Date de l'Événement</label>
        <input type="datetime-local" name="event_date" id="event_date" value=<?php echo $value; ?>>
<?php
    }
}

add_action('add_meta_boxes', ['WPU_Event_Date_Meta_Box', 'add']);
add_action('save_post', ['WPU_Event_Date_Meta_Box', 'save']);
