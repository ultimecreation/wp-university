<?php

// add custom post type
add_action('init', 'campus_post_type');
function campus_post_type()
{
    register_post_type('campus', array(
        'public' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'menu_icon' => 'dashicons-admin-multisite',
        'has_archive' => true,
        'rewrite' => array('slug' => 'campus'),
        'menu_position' => 5,
        'labels' => array(
            'name' => 'Campus',
            'add_new_item' => 'Ajouter un Campus',
            'edit_item' => 'Modifier un Campus',
            'all_items' => 'Tous les Campus',
            'singular_name' => 'Campus'
        )
    ));
}
////////////////////////
// add custom meta boxes
////////////////////////
add_action('add_meta_boxes', 'wpu_campus_related_program_metabox');
// add html code
function wpu_campus_related_program_html($post)
{
    global $wpdb;
    // get all available programs
    $programs = $wpdb->get_results(
        $wpdb->prepare("select ID,post_title from {$wpdb->prefix}posts where post_type=%s", 'program')
    );

    // get current programs
    $current_programs = $wpdb->get_results(
        $wpdb->prepare("select * from {$wpdb->prefix}campus_programs where campus_id=%d", $post->ID)
    );
    $current_programs_ids = [];
    foreach ($current_programs as $program) {
        array_push($current_programs_ids, $program->program_id);
    }
?>

    <label for="related_program_field" style='display:block;margin-bottom:1rem;'>Programme(s) Enseigné(s)</label>
    <select name="related_program_field[]" id="related_program_field" class="postbox" multiple style='width:100%;'>
        <?php foreach ($programs as $program) : ?>

            <option value=<?php echo $program->ID; ?> <?php if (in_array($program->ID, $current_programs_ids)) echo 'selected="selected"' ?>><?php echo $program->post_title; ?></option>
        <?php endforeach; ?>
    </select>
    <small><strong>Note:</strong> pour une selection multiple, appuyer et maintenir Ctrl enfoncer durant la sélection</small>
<?php
}
function wpu_campus_related_program_metabox()
{
    add_meta_box('campus_related_program', 'Programme(s)', 'wpu_campus_related_program_html', 'campus');
}

// save values
function wpu_campus_related_program_save($post_id)
{

    $programs_count = count($_POST['related_program_field']);
    if ($programs_count > 0) {
        global $wpdb;
        $wpdb->delete("{$wpdb->prefix}campus_programs", array('campus_id' => $post_id), array('%d'));
        foreach ($_POST['related_program_field'] as $program_id) {
            $program_id = htmlspecialchars(strip_tags((int) $program_id));
            $wpdb->query(
                $wpdb->prepare("insert into {$wpdb->prefix}campus_programs (campus_id,program_id) VALUES (%d,%d)", array($post_id, $program_id))
            );
        }
    }
    // echo "<pre>" . print_r(array($programs_count, $post_id, $_POST['related_program_field']), true) . "</pre>";
    // die('ok');
}
add_action('save_post', 'wpu_campus_related_program_save');
