<header>
    <h1><?php the_title(); ?></h1>
</header>
<article id="single-event">
    <div class="img">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="content">

        <?php the_content(); ?>
        <div class="date-hour">
            <p>Le: <strong><?php echo get_post_meta(get_the_ID(), 'event_date', true); ?></strong></p>
            <p>à: <strong><?php echo get_post_meta(get_the_ID(), 'event_hour', true); ?></strong></p>

        </div>
    </div>

</article>