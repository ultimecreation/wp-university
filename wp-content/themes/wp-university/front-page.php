<?php get_header(); ?>

<main id="front-page">
    <section id="header">
        <div class="container">
            <figure>
                <img src=<?php echo get_template_directory_uri() . "/assets/img/header-1.jpg"; ?> alt="">
                <figcaption>
                    <div class="slogan">
                        <h2>Notre Travail.</h2>
                        <h2>Votre Réussite.</h2>
                    </div>
                </figcaption>
            </figure>
        </div>
    </section>
    <?php
    $events = new WP_Query(array(
        'post_type' => 'event',
        'posts_per_page' => 2
    ));
    //echo "<pre>" . print_r(get_post_meta(get_the_ID(), 'event_date'), true) . "</pre>"; 
    ?>
    <?php if ($events->found_posts > 0) : ?>
        <section id="events">
            <header>
                <h1>Événements</h1>
            </header>
            <?php while ($events->have_posts()) : $events->the_post(); ?>
                <article class="event-post">
                    <div class="card-header">
                        <?php $date = get_post_meta(get_the_ID(), 'event_date', true);
                        $date = new \DateTime($date);
                        echo $date;
                        ?>

                        <p><?php echo get_date_from_gmt(get_post_meta(get_the_ID(), 'event_date', true), 'H:i'); ?></p>

                    </div>
                    <div class="card-body">
                        <h3><?php the_title(); ?></h3>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                </article>

            <?php endwhile; ?>



        </section>
    <?php else : ?>
        <p></p>

    <?php endif; ?>
    <section id="campus">
        <header>
            <h1>Campus</h1>
        </header>
    </section>
    <section id="professors">
        <header>
            <h1>Professeurs</h1>
        </header>
    </section>
</main>
<?php get_footer(); ?>