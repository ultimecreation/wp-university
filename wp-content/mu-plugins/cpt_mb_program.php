<?php

add_action('init', 'cursus_post_type');
function cursus_post_type()
{
    register_post_type('program', array(
        'public' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'menu_icon' => 'dashicons-admin-network',
        'has_archive' => true,
        'rewrite' => array('slug' => 'programmes'),
        'menu_position' => 5,
        'labels' => array(
            'name' => 'Programmes',
            'add_new_item' => 'Ajouter un Programme',
            'edit_item' => 'Modifier un Programme',
            'all_items' => 'Tous les Programmes',
            'singular_name' => 'Programme'
        )
    ));
}
////////////////////////
// add custom meta boxes
////////////////////////
add_action('add_meta_boxes', 'wpu_program_related_campus_metabox');
function wpu_program_related_campus_html($post)
{
    global $wpdb;
    // get all campus
    $campus = $wpdb->get_results(
        $wpdb->prepare("select ID,post_title from {$wpdb->prefix}posts where post_type=%s", 'campus')
    );


    // get currently saved campus
    $current_campus = $wpdb->get_results(
        $wpdb->prepare("select * from {$wpdb->prefix}campus_programs where program_id=%d", $post->ID)
    );
    $wpdb->flush();
    // create array of current campuses id
    $current_campus_ids = [];
    foreach ($current_campus as $current_camp) {
        array_push($current_campus_ids, $current_camp->campus_id);
    }


?>
    <label for="related_campus_field" style='display:block;margin-bottom:1rem;'>Campus</label>
    <select name="related_campus_field[]" id="related_campus_field" class="postbox" multiple style='width:100%;'>
        <?php foreach ($campus as $camp) : ?>
            <option value=<?php echo $camp->ID; ?> <?php if (in_array($camp->ID, $current_campus_ids)) echo 'selected="selected"'; ?>>
                <?php echo $camp->post_title; ?>
            </option>
        <?php endforeach; ?>

    </select>
<?php
}
function wpu_program_related_campus_metabox()
{
    add_meta_box('program_related_campus', 'Campus', 'wpu_program_related_campus_html', 'program');
}


// save values
function wpu_program_related_campus_save($post_id)
{
    $campus_count = !empty($_POST['related_campus_field']) ? count($_POST['related_campus_field']) : 0;
    // echo "<pre>" . print_r(array($campus_count, $_POST['related_campus_field']), true) . "</pre>";

    if ($campus_count > 0) {
        global $wpdb;
        // delete all entries related to this program
        $wpdb->delete("{$wpdb->prefix}campus_programs", array('program_id' => $post_id), array('%d'));

        //insert new values
        foreach ($_POST['related_campus_field'] as $campus_id) {
            $campus_id = htmlspecialchars(strip_tags((int) $campus_id));
            $wpdb->query(
                $wpdb->prepare("insert into {$wpdb->prefix}campus_programs (campus_id,program_id) VALUES (%d,%d)", array($campus_id, $post_id))
            );
        }
    }
}
add_action('save_post', 'wpu_program_related_campus_save');
