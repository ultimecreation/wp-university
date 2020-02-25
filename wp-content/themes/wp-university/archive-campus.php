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

            <?php while ($events->have_posts()) : $events->the_post(); ?>
                <article>
                    <h2><?php the_title(); ?></h2>
                    <?php the_content(); ?>


                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>