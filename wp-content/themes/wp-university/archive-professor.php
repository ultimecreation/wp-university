<?php get_header(); ?>
<main id="all-professors">
    <div class="container">
        <header>
            <h1>Tous les professeurs</h1>
        </header>

        <?php
        $events = new WP_Query(array(
            'posts_per_page' => 10,
            'post_type' => 'professor'
        ));

        // echo "<pre>" . print_r($events, true) . "</pre>";
        ?>
        <?php if ($events->found_posts > 0) : ?>

            <?php while ($events->have_posts()) : $events->the_post(); ?>
                <article>
                    <div class="professor-img">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="professor-detail">
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>


                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>