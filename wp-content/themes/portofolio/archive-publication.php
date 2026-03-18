<?php get_header(); ?>

<div class="mb-8 md:mb-12">
    <h1 class="text-5xl md:text-8xl font-black uppercase tracking-tighter mb-4 break-words">All Publications</h1>
    <p class="text-lg md:text-xl font-bold text-zinc-600">Complete list of research papers and academic
        publications.</p>
</div>

<div class="flex flex-col gap-4">
    <?php
    if ( have_posts() ) :
        $counter = 1;
        while ( have_posts() ) : the_post();
            // Get custom fields
            $authors = get_post_meta( get_the_ID(), 'authors', true );
            $journal = get_post_meta( get_the_ID(), 'journal', true );
            $year = get_post_meta( get_the_ID(), 'year', true );
            $doi = get_post_meta( get_the_ID(), 'doi', true );
            $link = get_post_meta( get_the_ID(), 'link', true );
            if ( ! $link ) {
                $link = '#';
            }
    ?>
    <div
        class="neo-card bg-white p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 group">
        <div class="flex gap-4 md:gap-6 items-center flex-1 w-full">
            <span class="text-3xl md:text-4xl font-black text-zinc-300 group-hover:text-primary transition-colors"><?php echo sprintf('%02d', $counter); ?></span>
            <div class="flex-1 min-w-0">
                <h4 class="text-lg md:text-xl font-black uppercase mb-2 break-words"><?php the_title(); ?></h4>
                <?php if ( $authors ) : ?>
                <p class="font-bold text-zinc-600 mb-1 text-sm md:text-base"><?php echo esc_html( $authors ); ?></p>
                <?php endif; ?>
                <p class="font-bold text-zinc-500 text-sm"><?php echo esc_html( $journal ); ?>, <?php echo esc_html( $year ); ?></p>
                <?php if ( $doi ) : ?>
                <p class="text-primary text-xs font-mono mt-2 break-all">DOI: <?php echo esc_html( $doi ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo esc_url( $link ); ?>"
            class="neo-btn bg-black text-white px-6 py-2 font-black uppercase text-sm tracking-widest whitespace-nowrap w-full md:w-auto text-center">
            Read Paper
        </a>
    </div>
    <?php
            $counter++;
        endwhile;
    else :
    ?>
    <div class="neo-card bg-white p-12 text-center">
        <p class="text-2xl font-bold text-zinc-400">No publications found.</p>
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
