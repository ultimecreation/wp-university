<?php get_header(); ?>

<main id="index">
    <div class="container">
        <?php if (have_posts()) : the_post(); ?>
            <header>
                <h1> <?php the_title(); ?></h1>
            </header>
            <section>
                <?php the_content(); ?>
            </section>
        <?php endif; ?>
    </div>

</main>
<?php get_footer(); ?>