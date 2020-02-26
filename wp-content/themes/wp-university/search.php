<?php get_header(); ?>
<?php
// search query
$s = get_search_query();
$query_results = new WP_Query(array(
    's' => $s,
    'orderby' => 'post-type',
    'order' => 'asc'
));

?>
<main id="search">
    <div class="container">
        <header>
            <h1>Résultat(s) de votre recherche</h1>
        </header>
        <?php if ($query_results->found_posts > 0) : ?>
            <?php while ($query_results->have_posts()) : $query_results->the_post(); ?>
                <article>
                    <h2><?php the_title(); ?></h2>
                    <?php the_excerpt(); ?>
                    <a href=<?php the_permalink(); ?> class="more">Consulter</a>
                    <?php
                    if ($query_results->post->post_type == 'program') echo " <small>programme</small>";
                    if ($query_results->post->post_type == 'campus') echo " <small>campus</small>";
                    if ($query_results->post->post_type == 'professor') echo " <small>professeur</small>";
                    if ($query_results->post->post_type == 'event') echo " <small>événement</small>";
                    ?>

                </article>

            <?php endwhile; ?>

        <?php else : ?>

            <p>Pas de résultat pour votre recherche</p>
        <?php endif; ?>
        <?php
        // echo "<pre>" . print_r($query_results, true) . "</pre>";
        ?>
    </div>

</main>
<?php get_footer(); ?>