<?php get_header(); ?>

<main id="front-page">
    <section id="header">
        <div class="overlay">

        </div>
        <?php get_search_form(); ?>
        <div class="slogan">
            <h1>Notre Travail.</h1>
            <h1>Votre Réussite.</h1>

        </div>


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

    ?>
    <?php if ($events->found_posts > 0) : ?>
        <section id="events">
            <div class="container">
                <header>
                    <h1>Événements</h1>
                </header>
                <div class="event-post">
                    <?php while ($events->have_posts()) : $events->the_post(); ?>

                        <article>
                            <figure>

                                <div class="event-img">
                                    <?php the_post_thumbnail();  ?>
                                    <figcaption>
                                        <div class="card-date">
                                            <?php $date = get_post_meta(get_the_ID(), 'event_date', true);
                                            $day = date_i18n('d M', strtotime($date));
                                            $year = date_i18n('Y', strtotime($date));
                                            $hour = get_post_meta(get_the_ID(), 'event_hour', true);
                                            echo "<p>$day $year</p><p>$hour</p>";
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
            </div>
        </section>

    <?php endif; ?>

    <!--EVENT SECTION END-->
    <!--CAMPUS SECTION-->
    <?php
    $campus = new WP_Query(array(
        'post_type' => 'campus',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'order' => 'ASC'

    ));

    ?>
    <?php if ($campus->found_posts > 0) : ?>
        <section id="campus">
            <div class="container">
                <header>
                    <h1>Campus</h1>
                </header>

                <div class="campus-post">
                    <?php while ($campus->have_posts()) : $campus->the_post(); ?>
                        <article>
                            <figure>
                                <div class="campus-img">
                                    <?php the_post_thumbnail(); ?>
                                    <figcaption>
                                        <h3> <?php the_title(); ?></h3>
                                        <div class="excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </figcaption>
                                </div>

                            </figure>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!--CAMPUS SECTION END-->
    <!--PROFESSOR SECTION -->
    <?php
    $programs = new WP_Query(array(
        'post_type' => 'program',
        'posts_per_page' => 2,
    ));

    ?>
    <?php if ($programs->found_posts > 0) : ?>
        <section id="programs">
            <div class="container">
                <header>
                    <h1>Programmes</h1>
                </header>

                <div class="program-post">
                    <?php while ($programs->have_posts()) : $programs->the_post(); ?>
                        <article>

                            <h2><?php the_title(); ?></h2>
                            <p><?php the_excerpt(); ?></p>
                            <div class="related-campus">
                                <?php
                                global $wpdb;
                                $related_campus = $wpdb->get_results(
                                    $wpdb->prepare("
                            SELECT *  FROM {$wpdb->prefix}campus_programs as campus_programs
                            JOIN {$wpdb->prefix}posts as campus
                            ON campus_programs.campus_id = campus.ID
                            WHERE campus_programs.program_id = '%d'
                            ", array(get_the_ID()))
                                );
                                if (count($related_campus) > 0) {
                                    echo "<p><strong>lieux(x) d'enseignement:</strong></p>";
                                    foreach ($related_campus as $campus) {

                                        echo "<p>$campus->post_title</p>";
                                    }
                                }
                                ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>


    <?php endif; ?>
    <!--PROFESSOR SECTION END-->
    <!--PROFESSOR SECTION -->
    <?php
    $professors = new WP_Query(array(
        'post_type' => 'professor',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'order' => 'ASC'
    ));

    ?>
    <?php if ($professors->found_posts > 0) : ?>
        <section id="professors">
            <div class="container">
                <header>
                    <h1>Professeurs</h1>
                </header>
                <div class="professor-post">
                    <?php while ($professors->have_posts()) : $professors->the_post(); ?>
                        <article>
                            <figure>
                                <div class="professor-img">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <figcaption>
                                    <h3><?php the_title(); ?></h3>
                                </figcaption>
                            </figure>


                            <div class="professor-info">
                                <?php the_excerpt(); ?>
                                <small>Contact: <?php echo get_post_meta(get_the_ID(), 'email', true) ?></small>
                            </div>


                        </article>
                    <?php endwhile; ?>
                </div>

            </div>
        </section>

    <?php endif; ?>
    <!--PROFESSOR SECTION END-->
</main>
<?php get_footer(); ?>