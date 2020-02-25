<?php

// add custom post type
add_action('init', 'campus_post_type');
function campus_post_type()
{
    register_post_type('campus', array(
        'public' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
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
// add custom meta boxes PROGRAMS
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

    $programs_count = !empty($_POST['related_program_field']) ? count($_POST['related_program_field']) : 0;
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
}
add_action('save_post', 'wpu_campus_related_program_save');


////////////////////////
// add custom meta boxes ADDRESS
////////////////////////
add_action('add_meta_boxes', 'wpu_campus_address_metabox');

// create html for custom meta box
function wpu_campus_address_html($post)
{
    $saved_address = get_post_meta(get_the_ID(), 'formatted_address', true);
?>
    <?php if ($saved_address) : ?>

        <iframe src="https://maps.google.com/maps?q=<?php echo $saved_address; ?>&hl=fr&z=14&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        <hr>
    <?php endif; ?>
    <details>
        <summary><strong>Configurer une Nouvelle adresse</strong></summary>
        <label for="address_field" style="display:block;margin:1rem 0;">Adresse Complète (numèro et voie)</label>
        <input type="text" name="address_field" id="address_field" class="postbox">

        <label for="zipcode_field" style="display:block;margin-bottom:1rem;">Code Postal</label>
        <input type="text" name="zipcode_field" id="zipcode_field" class="postbox">

        <label for="city_field" style="display:block;margin-bottom:1rem;">Ville</label>
        <input type="text" name="city_field" id="city_field" class="postbox">
    </details>

<?php
}
// create custom meta box
function wpu_campus_address_metabox()
{
    add_meta_box(
        'wpu_campus_address', //unique ID
        'Adresse', //Box title
        'wpu_campus_address_html', // fonction to call
        'campus'  // post-type
    );
}

// save values
add_action('save_post', 'wpu_campus_address_save');
function wpu_campus_address_save($post_id)
{
    // sanitize inputs
    $address_field = !empty($_POST['address_field']) ? sanitize_text_field($_POST['address_field']) : '';
    $zipcode_field = !empty($_POST['zipcode_field']) ? sanitize_text_field($_POST['zipcode_field']) : '';
    $city_field = !empty($_POST['city_field']) ? sanitize_text_field($_POST['city_field']) : '';
    if (!empty($address_field) && !empty($zipcode_field) && !empty($city_field)) {
        // create complete address and encode it
        $address = "$address_field,$zipcode_field,$city_field";
        $address_encoded = rawurldecode($address);

        // get coordinates from google
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address_encoded}&key=YOUR_KEY_HERE";
        $json = wp_remote_get($url);
        if (200 === (int) wp_remote_retrieve_response_code($json)) {
            $body = wp_remote_retrieve_body($json);
            $json = json_decode($body, true);
        }

        // parse results and sanitize them
        $formatted_address = sanitize_text_field($json['results'][0]['formatted_address']);
        $lat = sanitize_text_field($json['results'][0]['geometry']['location']['lat']);
        $lng = sanitize_text_field($json['results'][0]['geometry']['location']['lng']);

        // check in db if the fields exists

        $meta = get_post_meta($post_id);
        if (array_key_exists('formatted_address', $meta)) {
            update_post_meta($post_id, 'formatted_address', $formatted_address);
            update_post_meta($post_id, 'lat', $lat);
            update_post_meta($post_id, 'lng', $lng);
        }
        if (!array_key_exists('formatted_address', $meta)) {
            add_post_meta($post_id, 'formatted_address', $formatted_address, true);
            add_post_meta($post_id, 'lat', $lat, true);
            add_post_meta($post_id, 'lng', $lng, true);
        }
    }
}
