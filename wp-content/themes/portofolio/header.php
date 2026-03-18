<!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.svg" type="image/svg+xml" />
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.svg" type="image/svg+xml" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0047FF",
                        "secondary": "#00FF94",
                        "background-light": "#F5F5F5",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"],
                        "sans": ["Space Grotesk", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0px",
                        "lg": "0px",
                        "xl": "0px",
                        "full": "9999px"
                    },
                    borderWidth: {
                        '4': '4px',
                        '8': '8px',
                    },
                    boxShadow: {
                        'brutal': '8px 8px 0px 0px #000000',
                        'brutal-sm': '4px 4px 0px 0px #000000',
                        'brutal-lg': '12px 12px 0px 0px #000000',
                    }
                },
            },
        }
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class("bg-background-light dark:bg-background-dark font-display text-black dark:text-white antialiased"); ?>>
    <?php wp_body_open(); ?>
    <div class="layout-container flex h-full grow flex-col">
        <div class="sticky top-0 z-50 px-4 md:px-20 lg:px-40 py-5 bg-background-light dark:bg-background-dark">
            <header class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-zinc-900 border-4 border-black px-6 py-4 shadow-brutal gap-4 md:gap-0">
                <div class="flex items-center gap-4 text-black dark:text-white w-full md:w-auto justify-between">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-4">
                        <div class="size-8 bg-primary border-2 border-black flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-base">terminal</span>
                        </div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter">
                            <?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Pak Arif' ); ?>
                        </h2>
                    </a>
                </div>
                <div class="flex flex-col md:flex-row w-full md:w-auto gap-4 md:gap-8 items-center text-center">
                    <div class="flex flex-col md:flex-row items-center gap-4 md:gap-9 uppercase font-bold text-sm tracking-widest">
                        <a class="hover:underline decoration-4 decoration-primary underline-offset-4" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                        <a class="hover:underline decoration-4 decoration-primary underline-offset-4" href="<?php echo esc_url( get_post_type_archive_link( 'publication' ) ); ?>">Publications</a>
                        <a class="hover:underline decoration-4 decoration-primary underline-offset-4" href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ); ?>">Blog</a>
                        <a class="hover:underline decoration-4 decoration-primary underline-offset-4" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
                    </div>
                </div>
            </header>
        </div>

        <main class="px-4 md:px-20 lg:px-40 flex flex-1 justify-center py-10">
            <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
