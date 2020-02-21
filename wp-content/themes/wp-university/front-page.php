<?php get_header(); ?>

<main id="front-page">
    <section id="header">

        <figure>
            <img src=<?php echo get_template_directory_uri() . "/assets/img/header-1.jpg"; ?> alt="">
            <figcaption>
                <div class="slogan">
                    <h2>Notre Travail.</h2>
                    <h2>Votre Réussite.</h2>
                </div>
            </figcaption>
        </figure>

    </section>
    <!--EVENT SECTION-->
    <?php
    $events = new WP_Query(array(
        'post_type' => 'event',
        'posts_per_page' => 2,
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'value' => (new Datetime('now'))->format('Y-m-d'),
                'compare' => '>='
            )
        )
    ));
    //echo "<pre>" . print_r(get_post_meta(get_the_ID(), 'event_date'), true) . "</pre>"; 
    ?>
    <?php if ($events->found_posts > 0) : ?>
        <section id="events">
            <div class="container">
                <header>
                    <h1>Événements</h1>
                </header>
                <?php while ($events->have_posts()) : $events->the_post(); ?>
                    <article class="event-post">
                        <figure>

                            <div class="event-img">
                                <?php the_post_thumbnail();  ?>
                                <figcaption>
                                    <div class="card-date">
                                        <?php $date = get_post_meta(get_the_ID(), 'event_date', true);
                                        $day = date_i18n('d M', strtotime($date));
                                        $year = date_i18n('Y', strtotime($date));
                                        $hour = get_post_meta(get_the_ID(), 'event_hour', true);
                                        echo "<p>$day</p><p>$year</p><p>$hour</p>";
                                        ?>
                                    </div>
                                    <div class="card-body">
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php the_excerpt(); ?></p>
                                    </div>
                                </figcaption>
                            </div>


                        </figure>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>

    <?php endif; ?>
    <!--EVENT SECTION END-->
    <!--CAMPUS SECTION-->
    <?php

    ?>
    <section id="campus">
        <header>
            <h1>Campus</h1>
        </header>
    </section>
    <!--CAMPUS SECTION END-->
    <section id="professors">
        <header>
            <h1>Professeurs</h1>
        </header>
    </section>
</main>
<?php get_footer(); ?>