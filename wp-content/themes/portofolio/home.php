<?php get_header(); ?>

<div class="mb-8 md:mb-12">
    <h1 class="text-5xl md:text-8xl font-black uppercase tracking-tighter mb-4">All Blog Posts</h1>
    <p class="text-lg md:text-xl font-bold text-zinc-600">Insights, thoughts, and perspectives on technology and
        education.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $categories = get_the_category();
            $category_name = ! empty( $categories ) ? esc_html( $categories[0]->name ) : 'Uncategorized';
            $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
            if ( ! $thumbnail_url ) {
                $thumbnail_url = 'https://placehold.co/600x400/e5e5e5/666666?text=No+Image';
            }
    ?>
    <a href="<?php the_permalink(); ?>" class="neo-card bg-white group cursor-pointer block">
        <div class="aspect-video border-b-4 border-black overflow-hidden">
            <img alt="<?php the_title_attribute(); ?>"
                loading="lazy"
                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all"
                src="<?php echo esc_url( $thumbnail_url ); ?>" />
        </div>
        <div class="p-6">
            <div class="flex gap-2 mb-4">
                <span class="bg-secondary border-2 border-black px-2 py-0.5 text-xs font-black uppercase"><?php echo $category_name; ?></span>
            </div>
            <h3 class="text-2xl font-black uppercase mb-4 leading-none group-hover:text-primary transition-colors">
                <?php the_title(); ?></h3>
            <p class="font-medium text-zinc-700 mb-4"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-500"><?php echo get_the_date('M d, Y'); ?></span>
                <span
                    class="font-black uppercase text-sm underline decoration-2 underline-offset-4 group-hover:text-primary">Read
                    More →</span>
            </div>
        </div>
    </a>
    <?php
        endwhile;
    else :
    ?>
    <div class="neo-card bg-white p-12 text-center col-span-full">
        <p class="text-2xl font-bold text-zinc-400">No blog posts found.</p>
    </div>
    <?php endif; ?>
</div>

<!-- Pagination Controls -->
<div class="mt-12 flex justify-center items-center gap-2">
    <?php
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '← Prev', 'portofolio' ),
        'next_text' => __( 'Next →', 'portofolio' ),
        'class'     => 'pagination',
        'before_page_number' => '<span class="neo-btn bg-white px-4 py-2 font-bold uppercase text-sm mx-1 inline-block">',
        'after_page_number'  => '</span>',
    ) );
    ?>
</div>

<div class="mt-16 text-center">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
        class="neo-btn bg-primary text-white px-8 py-4 font-black uppercase text-lg tracking-tighter inline-block">
        Back to Home
    </a>
</div>

<?php get_footer(); ?>
