<?php get_header(); ?>
<main id="all-events">
    <div class="container">
        <header>
            <h1>Tous les événements</h1>
        </header>

        <?php
        $events = new WP_Query(array(
            'posts_per_page' => 10,
            'post_type' => 'event'
        ));

        // echo "<pre>" . print_r($events, true) . "</pre>";
        ?>
        <?php if ($events->found_posts > 0) : ?>

            <?php while ($events->have_posts()) : $events->the_post(); ?>
                <article>
                    <h2><?php the_title(); ?></h2>
                    <?php the_content(); ?>
                    <div class="date-hour">
                        <p>Le
                            <strong><?php echo date_i18n('d M Y', strtotime(get_post_meta(get_the_ID(), 'event_date', true))); ?></strong>
                        </p>
                        <p>à
                            <strong><?php echo get_post_meta(get_the_ID(), 'event_hour', true); ?></strong>
                        </p>
                    </div>

                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>