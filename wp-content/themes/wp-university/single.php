<?php get_header(); ?>

<main id="single">
    <div class="container">
        <?php if (have_posts()) : the_post(); ?>
            <?php get_template_part('partials/content', get_post_type()); ?>

        <?php endif; ?>
    </div>

</main>
<?php get_footer(); ?>