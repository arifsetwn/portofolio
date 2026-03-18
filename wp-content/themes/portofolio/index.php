<?php get_header(); ?>

<div class="mb-8 md:mb-12">
    <h1 class="text-5xl md:text-8xl font-black uppercase tracking-tighter mb-4">
        <?php single_post_title(); ?>
    </h1>
</div>

<div class="prose prose-lg max-w-none">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    else :
        echo '<p>No content found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
