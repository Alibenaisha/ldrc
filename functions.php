<?php
/**
 * LDRC theme functions.
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LDRC_VERSION', '1.0.0' );
define( 'LDRC_DIR', get_template_directory() );
define( 'LDRC_URI', get_template_directory_uri() );

require LDRC_DIR . '/inc/post-types.php';
require LDRC_DIR . '/inc/meta-boxes.php';
require LDRC_DIR . '/inc/customizer.php';
require LDRC_DIR . '/inc/template-tags.php';
require LDRC_DIR . '/inc/contact-form.php';

/**
 * Theme setup.
 */
function ldrc_setup() {
	load_theme_textdomain( 'ldrc', LDRC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 360,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'ldrc-card', 720, 450, true );
	add_image_size( 'ldrc-hero', 1920, 900, true );
	add_image_size( 'ldrc-logo', 320, 160, false );

	register_nav_menus(
		array(
			'primary' => __( 'القائمة الرئيسية', 'ldrc' ),
			'footer'  => __( 'قائمة التذييل', 'ldrc' ),
		)
	);
}
add_action( 'after_setup_theme', 'ldrc_setup' );

/**
 * Widget areas.
 */
function ldrc_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'الشريط الجانبي', 'ldrc' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'ldrc_widgets_init' );

/**
 * Styles and scripts.
 */
function ldrc_assets() {
	wp_enqueue_style(
		'ldrc-fonts',
		'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'ldrc-style', get_stylesheet_uri(), array( 'ldrc-fonts' ), LDRC_VERSION );
	wp_add_inline_style( 'ldrc-style', ldrc_customizer_css() );

	wp_enqueue_script( 'ldrc-main', LDRC_URI . '/assets/js/main.js', array(), LDRC_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'ldrc_assets' );

/**
 * Preconnect for Google Fonts.
 *
 * @param array  $urls          URLs.
 * @param string $relation_type Relation.
 * @return array
 */
function ldrc_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ldrc_resource_hints', 10, 2 );

/**
 * Register post types and flush rewrite rules on activation.
 */
function ldrc_activate() {
	ldrc_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ldrc_activate' );

/**
 * Archive page sizes and event ordering.
 *
 * @param WP_Query $query Query.
 */
function ldrc_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'ldrc_event' ) ) {
		$query->set( 'meta_key', '_ldrc_event_date' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
	if ( $query->is_post_type_archive( 'ldrc_conference' ) ) {
		$query->set( 'meta_key', '_ldrc_conf_start' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
	if ( $query->is_post_type_archive( 'ldrc_partner' ) ) {
		$query->set( 'posts_per_page', 48 );
		$query->set( 'orderby', 'menu_order title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'ldrc_pre_get_posts' );

/**
 * Shorter excerpts.
 *
 * @return int
 */
function ldrc_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'ldrc_excerpt_length' );

/**
 * Excerpt suffix.
 *
 * @return string
 */
function ldrc_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'ldrc_excerpt_more' );
