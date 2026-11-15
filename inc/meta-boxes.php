<?php
/**
 * Meta boxes for custom post types.
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field definitions per post type.
 *
 * @return array
 */
function ldrc_meta_fields() {
	return array(
		'ldrc_event'       => array(
			'_ldrc_event_date'     => array( 'label' => __( 'تاريخ الفعالية', 'ldrc' ), 'type' => 'date' ),
			'_ldrc_event_time'     => array( 'label' => __( 'الوقت', 'ldrc' ), 'type' => 'time' ),
			'_ldrc_event_location' => array( 'label' => __( 'المكان', 'ldrc' ), 'type' => 'text' ),
			'_ldrc_event_link'     => array( 'label' => __( 'رابط التسجيل', 'ldrc' ), 'type' => 'url' ),
		),
		'ldrc_conference'  => array(
			'_ldrc_conf_start'    => array( 'label' => __( 'تاريخ البداية', 'ldrc' ), 'type' => 'date' ),
			'_ldrc_conf_end'      => array( 'label' => __( 'تاريخ النهاية', 'ldrc' ), 'type' => 'date' ),
			'_ldrc_conf_location' => array( 'label' => __( 'المكان', 'ldrc' ), 'type' => 'text' ),
			'_ldrc_conf_link'     => array( 'label' => __( 'رابط التسجيل / الموقع', 'ldrc' ), 'type' => 'url' ),
		),
		'ldrc_publication' => array(
			'_ldrc_pub_authors' => array( 'label' => __( 'الباحثون', 'ldrc' ), 'type' => 'text' ),
			'_ldrc_pub_year'    => array( 'label' => __( 'سنة النشر', 'ldrc' ), 'type' => 'number' ),
			'_ldrc_pub_journal' => array( 'label' => __( 'المجلة / الجهة الناشرة', 'ldrc' ), 'type' => 'text' ),
			'_ldrc_pub_file'    => array( 'label' => __( 'رابط الملف (PDF) أو البيانات', 'ldrc' ), 'type' => 'url' ),
		),
		'ldrc_partner'     => array(
			'_ldrc_partner_url' => array( 'label' => __( 'موقع الشريك', 'ldrc' ), 'type' => 'url' ),
		),
	);
}

/**
 * Register meta boxes.
 */
function ldrc_add_meta_boxes() {
	foreach ( ldrc_meta_fields() as $post_type => $fields ) {
		add_meta_box(
			'ldrc_details',
			__( 'التفاصيل', 'ldrc' ),
			'ldrc_render_meta_box',
			$post_type,
			'side',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'ldrc_add_meta_boxes' );

/**
 * Render meta box.
 *
 * @param WP_Post $post Post.
 */
function ldrc_render_meta_box( $post ) {
	$fields = ldrc_meta_fields();
	if ( empty( $fields[ $post->post_type ] ) ) {
		return;
	}
	wp_nonce_field( 'ldrc_save_meta', 'ldrc_meta_nonce' );
	foreach ( $fields[ $post->post_type ] as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" class="widefat" dir="auto"></p>',
			esc_attr( $key ),
			esc_html( $field['label'] ),
			esc_attr( $field['type'] ),
			esc_attr( $value )
		);
	}
	if ( 'ldrc_partner' === $post->post_type ) {
		echo '<p class="description">' . esc_html__( 'استخدم "الصورة البارزة" لشعار الشريك.', 'ldrc' ) . '</p>';
	}
}

/**
 * Save meta.
 *
 * @param int $post_id Post ID.
 */
function ldrc_save_meta( $post_id ) {
	if ( ! isset( $_POST['ldrc_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ldrc_meta_nonce'] ), 'ldrc_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_type = get_post_type( $post_id );
	$fields    = ldrc_meta_fields();
	if ( empty( $fields[ $post_type ] ) ) {
		return;
	}
	foreach ( $fields[ $post_type ] as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		switch ( $field['type'] ) {
			case 'url':
				$value = esc_url_raw( $raw );
				break;
			case 'number':
				$value = absint( $raw );
				$value = $value ? (string) $value : '';
				break;
			case 'date':
				$value = preg_match( '/^\d{4}-\d{2}-\d{2}$/', $raw ) ? $raw : '';
				break;
			case 'time':
				$value = preg_match( '/^\d{2}:\d{2}$/', $raw ) ? $raw : '';
				break;
			default:
				$value = sanitize_text_field( $raw );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post', 'ldrc_save_meta' );
