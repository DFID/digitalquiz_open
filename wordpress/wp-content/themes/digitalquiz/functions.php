<?php
/**
 * DIGITAL_CAPABILITIES functions and definitions
 *
 * @package DIGITAL_CAPABILITIES
 * @author Filip Chereches-Tosa <filip@experiencematter.co.uk>
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'dfid_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dfid_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on DFID, use a find and replace
	 * to change 'dfid' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'dfid', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dfid' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dfid_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // dfid_setup
add_action( 'after_setup_theme', 'dfid_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function dfid_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dfid' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dfid_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dfid_scripts() {
	wp_enqueue_style( 'dfid-style', get_template_directory_uri() . '/dist/css/app.css' );

	wp_enqueue_script( 'lodash', get_template_directory_uri() . '/bower_components/lodash/dist/lodash.min.js', array(), '2.4.1', true );

	wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() . '/bower_components/jquery-waypoints/waypoints.min.js', array(), '2.0.5', true );
	wp_enqueue_script( 'jquery-onscreen', get_template_directory_uri() . '/bower_components/onScreen/jquery.onscreen.min.js', array(), '0.1.0', true );
	wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/bower_components/sticky/jquery.sticky.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'dfid-detectzoom', get_template_directory_uri() . '/js/detect-zoom.js', array(), '1.0.0', true );	
	wp_enqueue_script( 'dfid-highcharts', get_template_directory_uri() . '/js/highcharts.js', array(), '1.0.0', true );	
	wp_enqueue_script( 'dfid-highcharts-more', get_template_directory_uri() . '/js/highcharts-more.js', array(), '1.0.0', true );	
	wp_enqueue_script( 'dfid-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'dfid-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'dfid-main-js', get_template_directory_uri() . '/dist/js/app.min.js', array('jquery'), '0.0.1', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dfid_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// do_action( 'watupro_select_show_exam', $exam );