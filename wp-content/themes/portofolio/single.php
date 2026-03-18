<?php get_header(); ?>

<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $categories = get_the_category();
        $category_name = ! empty( $categories ) ? esc_html( $categories[0]->name ) : 'Uncategorized';
?>
<div class="max-w-[1350px] mx-auto w-full">
    <article class="mb-12">
        <div class="mb-8">
            <span class="bg-secondary border-2 border-black px-3 py-1 text-xs font-black uppercase inline-block mb-4"><?php echo $category_name; ?></span>
            <h1 class="text-4xl md:text-7xl font-black uppercase tracking-tighter mb-6 leading-none break-words"><?php the_title(); ?></h1>
            <div class="flex items-center gap-4 text-zinc-600 font-bold">
                <span><?php echo get_the_date('F d, Y'); ?></span>
            </div>
        </div>

        <div class="neo-card bg-white p-6 md:p-12">
            <div class="prose prose-lg max-w-none text-zinc-800">
                <?php 
                if ( has_excerpt() ) {
                    echo '<p class="text-xl font-bold mb-6 text-zinc-700">' . get_the_excerpt() . '</p>';
                }
                ?>
                <div class="text-lg leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </article>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ); ?>"
            class="neo-btn bg-primary text-white px-8 py-4 font-black uppercase text-lg tracking-tighter inline-block text-center hidden md:inline-block">
            Back to Blog
        </a>
        <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ); ?>"
            class="neo-btn bg-primary text-white px-8 py-4 font-black uppercase text-lg tracking-tighter inline-block text-center md:hidden">
            Back
        </a>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
            class="neo-btn bg-white text-black px-8 py-4 font-black uppercase text-lg tracking-tighter inline-block text-center">
            Home
        </a>
    </div>
</div>
<?php
    endwhile;
endif;
?>

<?php get_footer(); ?>
