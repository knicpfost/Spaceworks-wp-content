<?php
/**
 * Spaceworks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spaceworks
 */

if ( ! function_exists( 'spaceworks_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function spaceworks_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Spaceworks, use a find and replace
	 * to change 'spaceworks' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'spaceworks', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'spaceworks' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'spaceworks_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );
}
endif;
add_action( 'after_setup_theme', 'spaceworks_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet. 
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function spaceworks_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'spaceworks_content_width', 640 );
}
add_action( 'after_setup_theme', 'spaceworks_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function spaceworks_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'spaceworks' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'spaceworks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footerbar', 'spaceworks' ),
		'id'            => 'footerbar-1',
		'description'   => esc_html__( 'Add widgets here.', 'spaceworks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Gallery Bar', 'spaceworks' ),
		'id'            => 'gallerybar-1',
		'description'   => esc_html__( 'Add widgets here.', 'spaceworks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'spaceworks_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function spaceworks_scripts() {
	wp_enqueue_style( 'spaceworks-style', get_stylesheet_uri(), array(), '2.3' );
	
	wp_enqueue_style( 'spaceworks-font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_script( 'spaceworks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'spaceworks-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	wp_enqueue_script('jquery');	
	
	wp_enqueue_script( 'sw_salvattore', get_template_directory_uri() . '/js/salvattore.min.js', array(), '20151215', true );
	wp_enqueue_script( 'spaceworks-features', get_template_directory_uri() . '/js/sw-features.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'spaceworks_scripts' );


/**
 * Add media_featured Image Size
 */
add_image_size( 'media_featured', '600', '300', true );
add_image_size( 'media_hd', '1920', '1920', false );


/**
 * Implement custom HomeSlides post type
 */
require get_template_directory() . '/inc/home-slides.php';

require get_template_directory() . '/inc/snippets.php';

/**
 * Implement custom Projects post type
 */
require get_template_directory() . '/inc/projects.php';

/**
 * Implement custom Page Banners post type
 */
require get_template_directory() . '/inc/page-banners.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';


/**
 * Remove "Category:", "Tag:", etc
 */
add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '<span style="font-weight: 300;"></span>', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '<span style="font-weight: 300;">Filter:</span> ', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});


// Offset the main query on the main posts page (home.php)
function offset_main_query ( $query ) {
    if ( $query->is_home() && $query->is_main_query() && !$query->is_paged() ) {
         $query->set( 'offset', '2' );
         $query->set( 'posts_per_page', '8' );
    }
 }
add_action( 'pre_get_posts', 'offset_main_query' );


/**
 * Javascript for Load More
 *
 */
function be_load_more_js() {

	if ( is_home() || is_archive() ) {

		global $wp_query;
		$args = array(
			'nonce' => wp_create_nonce( 'be-load-more-nonce' ),
			'url'   => admin_url( 'admin-ajax.php' ),
			'query' => $wp_query->query,
		);
		
		wp_enqueue_script( 'be-load-more', get_stylesheet_directory_uri() . '/js/load-more2.js', array( 'jquery' ), '1.0', false );
		wp_localize_script( 'be-load-more', 'beloadmore', $args );

	}
}
add_action( 'wp_enqueue_scripts', 'be_load_more_js' );

/**
 * AJAX Load More 
 *
 */
function be_ajax_load_more() {
	
	check_ajax_referer( 'be-load-more-nonce', 'nonce' );
    
	$args = isset( $_POST['query'] ) ? $_POST['query'] : array();
	$args['post_type'] = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
	$args['paged'] = $_POST['page'];
	$args['post_status'] = 'publish';

	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		ajax_post_layout(false);
	endwhile; endif; wp_reset_postdata();
	$data = ob_get_clean();
	wp_send_json_success( $data );
}
add_action( 'wp_ajax_be_ajax_load_more', 'be_ajax_load_more' );
add_action( 'wp_ajax_nopriv_be_ajax_load_more', 'be_ajax_load_more' );

function ajax_post_layout( $first ) {
	
	$args2 = isset( $_POST['query'] ) ? $_POST['query'] : array();
	$current_tag_name = $args2['tag'];

	echo '<article id="post-' . get_the_ID() . '" ';
		if ( $first ) {
			post_class();
		} else {
			post_class('masonry-item');
		}
	echo '>';
	
	$permalink_url = esc_url( get_permalink() );
	if ( $current_tag_name == 'video' ) {
		$permalink_url = esc_url( get_permalink() ) . '#arve-video-1';
	}
	
	if ( $first ) {
		if ( has_post_thumbnail() ) {
			echo '<a href="' . $permalink_url . '" style="background-image: url(' . get_the_post_thumbnail_url('media_featured') . '); display: block; background-size: cover; background-position: top center; height: 300px; width: 100%;"></a>';
		}
	} else {
		if ( has_post_thumbnail() ) {
			echo '<a href="' . $permalink_url . '" rel="bookmark">';
				the_post_thumbnail('media_featured');
			echo '</a>';
		}
	}
	
	echo '<header class="entry-header">';
	the_title( '<h3 class="entry-title"><a href="' . $permalink_url . '" rel="bookmark">', '</a></h3>' );
	if ( $first ) {
		echo '<div class="excerpt">';
		the_excerpt();
		echo '</div>';
	}
		echo '<div class="entry-meta">';
		spaceworks_media_meta();
		echo '</div><!-- .entry-meta -->';

	echo '</header><!-- .entry-header -->';
	echo '</article>';
	
}


/**
* Add excerpt support for Pages, and then add those excerpts to the navigation
**/
require get_template_directory() . '/inc/nav-excerpts.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
} 