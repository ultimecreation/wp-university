<?php get_header(); ?>
<main id="all-campus">
    <div class="container">
        <header>
            <h1>Tous les campus</h1>
        </header>

        <?php
        $events = new WP_Query(array(
            'posts_per_page' => 10,
            'post_type' => 'campus'
        ));

        // echo "<pre>" . print_r($events, true) . "</pre>";
        ?>
        <?php if ($events->found_posts > 0) : ?>
            <div id="map"></div>

            <?php while ($events->have_posts()) : $events->the_post(); ?>
                <?php
                $lat = get_post_meta(get_the_ID(), 'lat', true);
                $lng = get_post_meta(get_the_ID(), 'lng', true);
                $address = str_replace(' ', '_', get_post_meta(get_the_ID(), 'formatted_address', true));


                ?>
                <article data-lat=<?php echo $lat; ?> data-lng=<?php echo $lng; ?> data-address=<?php echo $address; ?>>

                    <div class="content">
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>
                    <div class="img">
                        <?php the_post_thumbnail(); ?>
                    </div>

                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</main>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMAak_yvHpAgisbJ-qz4sKbNxKlRPc9zo&callback=initMap">
</script>
<?php get_footer(); ?>