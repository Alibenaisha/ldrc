<?php
/**
 * Custom post types: events, conferences, publications, partners.
 *
 * News uses the built-in "posts".
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Arabic labels.
 *
 * @param string $plural   Plural name.
 * @param string $singular Singular name.
 * @return array
 */
function ldrc_labels( $plural, $singular ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'add_new'            => __( 'إضافة جديد', 'ldrc' ),
		/* translators: %s: item name */
		'add_new_item'       => sprintf( __( 'إضافة %s', 'ldrc' ), $singular ),
		/* translators: %s: item name */
		'edit_item'          => sprintf( __( 'تعديل %s', 'ldrc' ), $singular ),
		/* translators: %s: item name */
		'new_item'           => sprintf( __( '%s جديد', 'ldrc' ), $singular ),
		/* translators: %s: item name */
		'view_item'          => sprintf( __( 'عرض %s', 'ldrc' ), $singular ),
		/* translators: %s: items name */
		'search_items'       => sprintf( __( 'بحث في %s', 'ldrc' ), $plural ),
		'not_found'          => __( 'لا توجد عناصر', 'ldrc' ),
		'not_found_in_trash' => __( 'لا توجد عناصر في سلة المهملات', 'ldrc' ),
		'all_items'          => $plural,
	);
}

/**
 * Register post types and taxonomies.
 */
function ldrc_register_post_types() {
	$common = array(
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => true,
	);

	register_post_type(
		'ldrc_event',
		array_merge(
			$common,
			array(
				'labels'    => ldrc_labels( __( 'الفعاليات', 'ldrc' ), __( 'فعالية', 'ldrc' ) ),
				'menu_icon' => 'dashicons-calendar-alt',
				'rewrite'   => array( 'slug' => 'events' ),
				'supports'  => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_post_type(
		'ldrc_conference',
		array_merge(
			$common,
			array(
				'labels'    => ldrc_labels( __( 'المؤتمرات', 'ldrc' ), __( 'مؤتمر', 'ldrc' ) ),
				'menu_icon' => 'dashicons-groups',
				'rewrite'   => array( 'slug' => 'conferences' ),
				'supports'  => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_post_type(
		'ldrc_publication',
		array_merge(
			$common,
			array(
				'labels'    => ldrc_labels( __( 'الأبحاث والبيانات', 'ldrc' ), __( 'بحث', 'ldrc' ) ),
				'menu_icon' => 'dashicons-media-document',
				'rewrite'   => array( 'slug' => 'research' ),
				'supports'  => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_taxonomy(
		'ldrc_research_area',
		array( 'ldrc_publication' ),
		array(
			'labels'            => ldrc_labels( __( 'مجالات البحث', 'ldrc' ), __( 'مجال بحث', 'ldrc' ) ),
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'research-area' ),
		)
	);

	register_post_type(
		'ldrc_partner',
		array_merge(
			$common,
			array(
				'labels'             => ldrc_labels( __( 'الشركاء', 'ldrc' ), __( 'شريك', 'ldrc' ) ),
				'menu_icon'          => 'dashicons-networking',
				'rewrite'            => array( 'slug' => 'partners' ),
				'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
				'publicly_queryable' => true,
			)
		)
	);
}
add_action( 'init', 'ldrc_register_post_types' );

/**
 * Hide single partner pages: redirect to partners archive.
 */
function ldrc_partner_redirect() {
	if ( is_singular( 'ldrc_partner' ) ) {
		wp_safe_redirect( get_post_type_archive_link( 'ldrc_partner' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'ldrc_partner_redirect' );
