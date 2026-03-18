<?php
/**
 * Portofolio Theme Functions and Definitions
 */

if ( ! function_exists( 'portofolio_setup' ) ) :
    function portofolio_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Register navigation menus.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'portofolio' ),
            'footer'  => esc_html__( 'Footer Menu', 'portofolio' ),
        ) );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );
    }
endif;
add_action( 'after_setup_theme', 'portofolio_setup' );

/**
 * Enqueue scripts and styles.
 */
function portofolio_scripts() {
    // Enqueue Google Fonts & Material Symbols
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap', array(), null );
    wp_enqueue_style( 'material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null );

    // Enqueue Custom Styles
    wp_enqueue_style( 'portofolio-style', get_template_directory_uri() . '/css/styles.css', array(), '1.0.0' );
    wp_enqueue_style( 'portofolio-main-style', get_stylesheet_uri(), array(), '1.0.0' );


}
add_action( 'wp_enqueue_scripts', 'portofolio_scripts' );

/**
 * Register Custom Post Type: Publication
 */
function portofolio_register_cpt_publication() {
    $labels = array(
        'name'                  => _x( 'Publications', 'Post Type General Name', 'portofolio' ),
        'singular_name'         => _x( 'Publication', 'Post Type Singular Name', 'portofolio' ),
        'menu_name'             => __( 'Publications', 'portofolio' ),
        'all_items'             => __( 'All Publications', 'portofolio' ),
        'add_new_item'          => __( 'Add New Publication', 'portofolio' ),
        'add_new'               => __( 'Add New', 'portofolio' ),
        'new_item'              => __( 'New Publication', 'portofolio' ),
        'edit_item'             => __( 'Edit Publication', 'portofolio' ),
        'update_item'           => __( 'Update Publication', 'portofolio' ),
        'view_item'             => __( 'View Publication', 'portofolio' ),
        'search_items'          => __( 'Search Publication', 'portofolio' ),
    );
    $args = array(
        'label'                 => __( 'Publication', 'portofolio' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ), // We will use a custom meta box instead of the generic 'custom-fields'
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-book',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'publication', $args );
}
add_action( 'init', 'portofolio_register_cpt_publication', 0 );

/**
 * Add Meta Box for Publication Details
 */
function portofolio_add_publication_meta_box() {
    add_meta_box(
        'publication_details',
        __( 'Publication Details', 'portofolio' ),
        'portofolio_publication_meta_box_callback',
        'publication',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'portofolio_add_publication_meta_box' );

/**
 * Meta Box Callback
 */
function portofolio_publication_meta_box_callback( $post ) {
    wp_nonce_field( 'portofolio_save_publication_data', 'portofolio_publication_meta_box_nonce' );

    $authors = get_post_meta( $post->ID, 'authors', true );
    $journal = get_post_meta( $post->ID, 'journal', true );
    $year    = get_post_meta( $post->ID, 'year', true );
    $doi     = get_post_meta( $post->ID, 'doi', true );
    $link    = get_post_meta( $post->ID, 'link', true );

    ?>
    <style>
        .portofolio-meta-row { margin-bottom: 15px; }
        .portofolio-meta-row label { display: block; font-weight: bold; margin-bottom: 5px; }
        .portofolio-meta-row input { width: 100%; max-width: 600px; }
    </style>
    <div class="portofolio-meta-row">
        <label for="portofolio_authors"><?php _e( 'Authors', 'portofolio' ); ?></label>
        <input type="text" id="portofolio_authors" name="portofolio_authors" value="<?php echo esc_attr( $authors ); ?>" placeholder="e.g. Arif Setiawan, Jane Doe" />
    </div>
    <div class="portofolio-meta-row">
        <label for="portofolio_journal"><?php _e( 'Journal/Conference Name', 'portofolio' ); ?></label>
        <input type="text" id="portofolio_journal" name="portofolio_journal" value="<?php echo esc_attr( $journal ); ?>" placeholder="e.g. International Journal of Educational Technology" />
    </div>
    <div class="portofolio-meta-row">
        <label for="portofolio_year"><?php _e( 'Year', 'portofolio' ); ?></label>
        <input type="text" id="portofolio_year" name="portofolio_year" value="<?php echo esc_attr( $year ); ?>" placeholder="e.g. 2026" />
    </div>
    <div class="portofolio-meta-row">
        <label for="portofolio_doi"><?php _e( 'DOI', 'portofolio' ); ?></label>
        <input type="text" id="portofolio_doi" name="portofolio_doi" value="<?php echo esc_attr( $doi ); ?>" placeholder="e.g. 10.1234/ijet.v1i1.1" />
    </div>
    <div class="portofolio-meta-row">
        <label for="portofolio_link"><?php _e( 'Link to Paper', 'portofolio' ); ?></label>
        <input type="url" id="portofolio_link" name="portofolio_link" value="<?php echo esc_attr( $link ); ?>" placeholder="https://..." />
    </div>
    <?php
}

/**
 * Save Meta Box Data
 */
function portofolio_save_publication_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['portofolio_publication_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['portofolio_publication_meta_box_nonce'], 'portofolio_save_publication_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['portofolio_authors'] ) ) {
        update_post_meta( $post_id, 'authors', sanitize_text_field( $_POST['portofolio_authors'] ) );
    }
    if ( isset( $_POST['portofolio_journal'] ) ) {
        update_post_meta( $post_id, 'journal', sanitize_text_field( $_POST['portofolio_journal'] ) );
    }
    if ( isset( $_POST['portofolio_year'] ) ) {
        update_post_meta( $post_id, 'year', sanitize_text_field( $_POST['portofolio_year'] ) );
    }
    if ( isset( $_POST['portofolio_doi'] ) ) {
        update_post_meta( $post_id, 'doi', sanitize_text_field( $_POST['portofolio_doi'] ) );
    }
    if ( isset( $_POST['portofolio_link'] ) ) {
        update_post_meta( $post_id, 'link', sanitize_url( $_POST['portofolio_link'] ) );
    }
}
add_action( 'save_post_publication', 'portofolio_save_publication_meta_box_data' );

