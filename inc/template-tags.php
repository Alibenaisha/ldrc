<?php
/**
 * Template helpers.
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline SVG icons (stroke icons, currentColor).
 *
 * @param string $name Icon name.
 * @return string
 */
function ldrc_icon( $name ) {
	$paths = array(
		'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
		'pin'      => '<path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
		'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
		'file'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>',
		'users'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
		'arrow'    => '<path d="M19 12H5M12 19l-7-7 7-7"/>',
		'tooth'    => '<path d="M12 5.5C10.5 4 8.6 3 7 3 4.2 3 3 5.3 3 8c0 3 1 5 1.7 7.5.6 2.3 1 5.5 2.8 5.5 1.9 0 1.9-4.5 4.5-4.5s2.6 4.5 4.5 4.5c1.8 0 2.2-3.2 2.8-5.5C20 13 21 11 21 8c0-2.7-1.2-5-4-5-1.6 0-3.5 1-5 2.5z"/>',
		'flask'    => '<path d="M9 3h6M10 3v6L4.5 18.5A2 2 0 0 0 6.2 21h11.6a2 2 0 0 0 1.7-2.5L14 9V3"/><path d="M7 15h10"/>',
		'chart'    => '<path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/>',
		'book'     => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-5"/>',
		'menu'     => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'close'    => '<path d="M18 6 6 18M6 6l12 12"/>',
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
		'link'     => '<path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/>',
	);
	$brand = array(
		'facebook'  => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v2H8v4h2v8h4v-8h3l1-4h-4V8z" fill="currentColor" stroke="none"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>',
		'x'         => '<path d="M4 4l16 16M20 4 4 20" />',
		'linkedin'  => '<rect x="3" y="9" width="4" height="12"/><circle cx="5" cy="5" r="2"/><path d="M11 21V9h4v2a4 4 0 0 1 6 3.5V21h-4v-6a2 2 0 0 0-4 0v6z"/>',
		'youtube'   => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 5 3-5 3z" fill="currentColor"/>',
	);
	$all = array_merge( $paths, $brand );
	if ( ! isset( $all[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon icon-' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $all[ $name ] . '</svg>';
}

/**
 * Localised date from Y-m-d.
 *
 * @param string $ymd    Date.
 * @param string $format Format.
 * @return string
 */
function ldrc_date( $ymd, $format = 'j F Y' ) {
	if ( ! $ymd ) {
		return '';
	}
	$ts = strtotime( $ymd . ' 12:00:00' );
	return $ts ? date_i18n( $format, $ts ) : '';
}

/**
 * Section heading.
 *
 * @param string $kicker   Small label.
 * @param string $title    Title.
 * @param string $link     "View all" link.
 * @param string $link_txt Link text.
 */
function ldrc_section_head( $kicker, $title, $link = '', $link_txt = '' ) {
	echo '<div class="section-head">';
	echo '<div><span class="kicker">' . esc_html( $kicker ) . '</span><h2>' . esc_html( $title ) . '</h2></div>';
	if ( $link ) {
		echo '<a class="link-more" href="' . esc_url( $link ) . '">' . esc_html( $link_txt ? $link_txt : __( 'عرض الكل', 'ldrc' ) ) . ' ' . ldrc_icon( 'arrow' ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div>';
}

/**
 * Social links list.
 */
function ldrc_social_links() {
	$networks = array( 'facebook', 'instagram', 'x', 'linkedin', 'youtube' );
	$out      = '';
	foreach ( $networks as $net ) {
		$url = ldrc_mod( 'social_' . $net );
		if ( $url ) {
			$out .= '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( $net ) . '">' . ldrc_icon( $net ) . '</a>';
		}
	}
	if ( $out ) {
		echo '<div class="social">' . $out . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Menu fallback when no menu is assigned yet.
 */
function ldrc_menu_fallback() {
	$items = array(
		home_url( '/' )                                  => __( 'الرئيسية', 'ldrc' ),
		home_url( '/#about' )                            => __( 'عن المركز', 'ldrc' ),
		ldrc_posts_page_url()                            => __( 'الأخبار', 'ldrc' ),
		get_post_type_archive_link( 'ldrc_publication' ) => __( 'الأبحاث والبيانات', 'ldrc' ),
		get_post_type_archive_link( 'ldrc_event' )       => __( 'الفعاليات', 'ldrc' ),
		get_post_type_archive_link( 'ldrc_conference' )  => __( 'المؤتمرات', 'ldrc' ),
		get_post_type_archive_link( 'ldrc_partner' )     => __( 'الشركاء', 'ldrc' ),
		ldrc_contact_url()                               => __( 'اتصل بنا', 'ldrc' ),
	);
	echo '<ul class="menu">';
	foreach ( $items as $url => $label ) {
		if ( $url ) {
			echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}
	echo '</ul>';
}

/**
 * URL of the news (posts) page.
 *
 * @return string
 */
function ldrc_posts_page_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( $page_id ) {
		return get_permalink( $page_id );
	}
	$cat = get_category_by_slug( 'news' );
	if ( $cat ) {
		return get_category_link( $cat );
	}
	return add_query_arg( 'post_type', 'post', home_url( '/' ) );
}

/**
 * URL of the contact page (first page using the contact template).
 *
 * @return string
 */
function ldrc_contact_url() {
	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-templates/contact.php',
			'number'     => 1,
		)
	);
	return $pages ? get_permalink( $pages[0] ) : home_url( '/#contact' );
}

/**
 * Card meta line for any supported post type.
 *
 * @param int|null $post_id Post ID.
 */
function ldrc_card_meta( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$type    = get_post_type( $post_id );
	$items   = array();

	if ( 'ldrc_event' === $type ) {
		$date = get_post_meta( $post_id, '_ldrc_event_date', true );
		$loc  = get_post_meta( $post_id, '_ldrc_event_location', true );
		if ( $date ) {
			$items[] = ldrc_icon( 'calendar' ) . esc_html( ldrc_date( $date ) );
		}
		if ( $loc ) {
			$items[] = ldrc_icon( 'pin' ) . esc_html( $loc );
		}
	} elseif ( 'ldrc_conference' === $type ) {
		$start = get_post_meta( $post_id, '_ldrc_conf_start', true );
		$end   = get_post_meta( $post_id, '_ldrc_conf_end', true );
		$loc   = get_post_meta( $post_id, '_ldrc_conf_location', true );
		if ( $start ) {
			$range   = ldrc_date( $start ) . ( $end && $end !== $start ? ' — ' . ldrc_date( $end ) : '' );
			$items[] = ldrc_icon( 'calendar' ) . esc_html( $range );
		}
		if ( $loc ) {
			$items[] = ldrc_icon( 'pin' ) . esc_html( $loc );
		}
	} elseif ( 'ldrc_publication' === $type ) {
		$authors = get_post_meta( $post_id, '_ldrc_pub_authors', true );
		$year    = get_post_meta( $post_id, '_ldrc_pub_year', true );
		if ( $authors ) {
			$items[] = ldrc_icon( 'users' ) . esc_html( $authors );
		}
		if ( $year ) {
			$items[] = ldrc_icon( 'calendar' ) . esc_html( $year );
		}
	} else {
		$items[] = ldrc_icon( 'calendar' ) . esc_html( get_the_date( '', $post_id ) );
	}

	if ( $items ) {
		echo '<ul class="meta"><li>' . implode( '</li><li>', $items ) . '</li></ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Whether an event/conference date is upcoming.
 *
 * @param int|null $post_id Post ID.
 * @return bool
 */
function ldrc_is_upcoming( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$type    = get_post_type( $post_id );
	$key     = 'ldrc_event' === $type ? '_ldrc_event_date' : ( 'ldrc_conference' === $type ? '_ldrc_conf_end' : '' );
	if ( ! $key ) {
		return false;
	}
	$date = get_post_meta( $post_id, $key, true );
	if ( ! $date && 'ldrc_conference' === $type ) {
		$date = get_post_meta( $post_id, '_ldrc_conf_start', true );
	}
	return $date && $date >= current_time( 'Y-m-d' );
}

/**
 * Placeholder cards for empty sections (until content is added).
 *
 * @param string $label Section label.
 * @param int    $count Count.
 */
function ldrc_placeholder_cards( $label, $count = 3 ) {
	for ( $i = 1; $i <= $count; $i++ ) {
		echo '<article class="card card--placeholder"><div class="card-media"><span>' . ldrc_icon( 'tooth' ) . '</span></div><div class="card-body">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		/* translators: %s: section name */
		echo '<h3>' . esc_html( sprintf( __( 'سيتم إضافة %s قريباً', 'ldrc' ), $label ) ) . '</h3>';
		echo '<p>' . esc_html__( 'هذا محتوى مؤقت يظهر حتى تتم إضافة المحتوى من لوحة التحكم.', 'ldrc' ) . '</p>';
		echo '</div></article>';
	}
}

/**
 * Simple breadcrumbs.
 */
function ldrc_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	$crumbs = array( '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'الرئيسية', 'ldrc' ) . '</a>' );

	if ( is_singular() ) {
		$type = get_post_type();
		if ( 'post' === $type ) {
			$crumbs[] = '<a href="' . esc_url( ldrc_posts_page_url() ) . '">' . esc_html__( 'الأخبار', 'ldrc' ) . '</a>';
		} elseif ( 'page' !== $type ) {
			$obj = get_post_type_object( $type );
			if ( $obj && $obj->has_archive ) {
				$crumbs[] = '<a href="' . esc_url( get_post_type_archive_link( $type ) ) . '">' . esc_html( $obj->labels->name ) . '</a>';
			}
		}
		$crumbs[] = '<span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_post_type_archive() ) {
		$crumbs[] = '<span>' . esc_html( post_type_archive_title( '', false ) ) . '</span>';
	} elseif ( is_home() ) {
		$crumbs[] = '<span>' . esc_html__( 'الأخبار', 'ldrc' ) . '</span>';
	} elseif ( is_search() ) {
		$crumbs[] = '<span>' . esc_html__( 'نتائج البحث', 'ldrc' ) . '</span>';
	} elseif ( is_archive() ) {
		$crumbs[] = '<span>' . esc_html( wp_strip_all_tags( get_the_archive_title() ) ) . '</span>';
	} elseif ( is_404() ) {
		$crumbs[] = '<span>404</span>';
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'مسار التنقل', 'ldrc' ) . '">' . implode( '<span class="sep">/</span>', $crumbs ) . '</nav>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Page header banner used by inner pages.
 *
 * @param string $title    Title.
 * @param string $subtitle Subtitle.
 */
function ldrc_page_header( $title, $subtitle = '' ) {
	echo '<header class="page-hero"><div class="container">';
	ldrc_breadcrumbs();
	echo '<h1>' . esc_html( $title ) . '</h1>';
	if ( $subtitle ) {
		echo '<p>' . esc_html( $subtitle ) . '</p>';
	}
	echo '</div></header>';
}

/**
 * Archive subtitles per post type.
 *
 * @param string $type Post type.
 * @return string
 */
function ldrc_archive_subtitle( $type ) {
	$map = array(
		'ldrc_event'       => __( 'ورش العمل والمحاضرات والأنشطة التي ينظمها المركز أو يشارك فيها.', 'ldrc' ),
		'ldrc_conference'  => __( 'المؤتمرات العلمية الوطنية والدولية في مجال طب الأسنان.', 'ldrc' ),
		'ldrc_publication' => __( 'الأبحاث المنشورة والتقارير وقواعد البيانات الصادرة عن المركز.', 'ldrc' ),
		'ldrc_partner'     => __( 'المؤسسات والجامعات والجهات التي نتعاون معها.', 'ldrc' ),
		'post'             => __( 'آخر أخبار المركز وإعلاناته.', 'ldrc' ),
	);
	return isset( $map[ $type ] ) ? $map[ $type ] : '';
}

/**
 * Upcoming items first; falls back to the most recent ones.
 *
 * @param string $type     Post type.
 * @param string $meta_key Date meta key.
 * @param int    $count    Count.
 * @return WP_Query
 */
function ldrc_front_dated_query( $type, $meta_key, $count = 3 ) {
	$q = new WP_Query(
		array(
			'post_type'      => $type,
			'posts_per_page' => $count,
			'meta_key'       => $meta_key,
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => $meta_key,
					'value'   => current_time( 'Y-m-d' ),
					'compare' => '>=',
					'type'    => 'DATE',
				),
			),
		)
	);
	if ( $q->have_posts() ) {
		return $q;
	}
	return new WP_Query(
		array(
			'post_type'      => $type,
			'posts_per_page' => $count,
			'meta_key'       => $meta_key,
			'orderby'        => 'meta_value',
			'order'          => 'DESC',
		)
	);
}
