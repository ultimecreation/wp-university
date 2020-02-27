<header>
    <h1><?php the_title(); ?></h1>
</header>
<article id="single-professor">

    <div class="content">
        <?php the_content(); ?>
        <p><strong>Matière enseignée: </strong><?php echo get_post_meta(get_the_ID(), 'program', true); ?></p>
        <p><strong>Contact: </strong><?php echo get_post_meta(get_the_ID(), 'email', true); ?></p>
    </div>
    <div class="img">
        <?php the_post_thumbnail(); ?>
    </div>
</article>