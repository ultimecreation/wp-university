<form id="searchform" method="get" action="<?php echo home_url('/'); ?>">

    <input type="text" class="search-field" name="s" placeholder="Entrez votre recherche" value="<?php the_search_query(); ?>">
    <input type="hidden" name="post_type[]" value="campus" />
    <input type="hidden" name="post_type[]" value="event" />
    <input type="hidden" name="post_type[]" value="program" />
    <input type="hidden" name="post_type[]" value="professor" />
    <input type="submit" value="Rechercher">
</form>