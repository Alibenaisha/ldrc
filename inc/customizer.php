<?php
/**
 * Customizer: everything the center will change without touching code.
 *
 * All texts are placeholders until the center sends final content.
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default values (placeholders).
 *
 * @return array
 */
function ldrc_defaults() {
	return array(
		'color_primary'   => '#0b6e8a',
		'color_accent'    => '#16b3a3',
		'color_dark'      => '#0b2533',

		'hero_kicker'     => 'المركز الليبي لأبحاث طب الأسنان',
		'hero_title'      => 'نطوّر صحة الفم والأسنان في ليبيا بالبحث العلمي',
		'hero_text'       => 'مركز وطني يجمع الباحثين والأطباء والمؤسسات لإنتاج المعرفة، ونشر البيانات، وتنظيم المؤتمرات والبرامج التدريبية في مجال طب الأسنان.',
		'hero_image'      => '',
		'hero_btn1_text'  => 'تعرّف على المركز',
		'hero_btn1_url'   => '#about',
		'hero_btn2_text'  => 'الأبحاث والبيانات',
		'hero_btn2_url'   => '',

		'about_title'     => 'عن المركز',
		'about_text'      => 'نص تعريفي مؤقت: المركز الليبي لأبحاث طب الأسنان جهة بحثية تعنى بدراسة واقع صحة الفم والأسنان، ودعم الباحثين، وبناء قواعد بيانات وطنية تساعد صانعي القرار والممارسين. سيتم استبدال هذا النص بالنص الرسمي للمركز.',
		'about_image'     => '',
		'about_vision'    => 'أن يكون المركز المرجع الوطني الأول لأبحاث طب الأسنان في ليبيا.',
		'about_mission'   => 'إنتاج بحث علمي رصين ونشر البيانات وبناء الشراكات لخدمة صحة المجتمع.',

		'stat1_num'       => '120',
		'stat1_label'     => 'بحث منشور',
		'stat2_num'       => '35',
		'stat2_label'     => 'باحث ومتعاون',
		'stat3_num'       => '18',
		'stat3_label'     => 'مؤتمر وورشة عمل',
		'stat4_num'       => '12',
		'stat4_label'     => 'شريك محلي ودولي',

		'area1_title'     => 'صحة الفم المجتمعية',
		'area1_text'      => 'مسوحات ودراسات وبائية حول انتشار أمراض الفم والأسنان.',
		'area2_title'     => 'طب أسنان الأطفال',
		'area2_text'      => 'برامج الوقاية والكشف المبكر لدى الأطفال وطلاب المدارس.',
		'area3_title'     => 'المواد والتقنيات الحديثة',
		'area3_text'      => 'تقييم المواد السنية والتقنيات الرقمية في العيادات الليبية.',
		'area4_title'     => 'التعليم والتدريب',
		'area4_text'      => 'دورات وبرامج تطوير مهني للأطباء والباحثين الشباب.',

		'contact_address' => 'ليبيا — العنوان سيضاف لاحقاً',
		'contact_phone'   => '+218 00 000 0000',
		'contact_email'   => 'info@example.ly',
		'contact_hours'   => 'الأحد – الخميس، 9:00 – 15:00',
		'contact_map'     => '',
		'contact_to'      => '',

		'social_facebook'  => '',
		'social_instagram' => '',
		'social_x'         => '',
		'social_linkedin'  => '',
		'social_youtube'   => '',

		'footer_about'    => 'المركز الليبي لأبحاث طب الأسنان — نحو بحث علمي يخدم صحة الفم والأسنان في ليبيا.',
	);
}

/**
 * Get a theme mod with its default.
 *
 * @param string $key Key.
 * @return string
 */
function ldrc_mod( $key ) {
	$defaults = ldrc_defaults();
	return get_theme_mod( $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function ldrc_customize_register( $wp_customize ) {
	$d = ldrc_defaults();

	$wp_customize->add_panel(
		'ldrc_panel',
		array(
			'title'    => __( 'إعدادات موقع المركز', 'ldrc' ),
			'priority' => 20,
		)
	);

	$add = function ( $section, $key, $label, $type = 'text' ) use ( $wp_customize, $d ) {
		$sanitize = 'sanitize_text_field';
		if ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'textarea' === $type ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( 'email' === $type ) {
			$sanitize = 'sanitize_email';
		} elseif ( 'color' === $type ) {
			$sanitize = 'sanitize_hex_color';
		} elseif ( 'image' === $type ) {
			$sanitize = 'esc_url_raw';
		}

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => isset( $d[ $key ] ) ? $d[ $key ] : '',
				'sanitize_callback' => $sanitize,
			)
		);

		if ( 'color' === $type ) {
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array( 'label' => $label, 'section' => $section ) ) );
		} elseif ( 'image' === $type ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array( 'label' => $label, 'section' => $section ) ) );
		} else {
			$wp_customize->add_control(
				$key,
				array(
					'label'   => $label,
					'section' => $section,
					'type'    => $type,
				)
			);
		}
	};

	$sections = array(
		'ldrc_colors'  => __( 'الألوان', 'ldrc' ),
		'ldrc_hero'    => __( 'الواجهة الرئيسية', 'ldrc' ),
		'ldrc_about'   => __( 'عن المركز', 'ldrc' ),
		'ldrc_stats'   => __( 'الأرقام والإحصائيات', 'ldrc' ),
		'ldrc_areas'   => __( 'مجالات العمل', 'ldrc' ),
		'ldrc_contact' => __( 'معلومات التواصل', 'ldrc' ),
		'ldrc_social'  => __( 'حسابات التواصل الاجتماعي', 'ldrc' ),
		'ldrc_footer'  => __( 'التذييل', 'ldrc' ),
	);
	$i = 10;
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section(
			$id,
			array(
				'title'    => $title,
				'panel'    => 'ldrc_panel',
				'priority' => $i,
			)
		);
		$i += 10;
	}

	$add( 'ldrc_colors', 'color_primary', __( 'اللون الأساسي', 'ldrc' ), 'color' );
	$add( 'ldrc_colors', 'color_accent', __( 'اللون الثانوي', 'ldrc' ), 'color' );
	$add( 'ldrc_colors', 'color_dark', __( 'اللون الداكن (التذييل والعناوين)', 'ldrc' ), 'color' );

	$add( 'ldrc_hero', 'hero_kicker', __( 'العنوان الصغير', 'ldrc' ) );
	$add( 'ldrc_hero', 'hero_title', __( 'العنوان الرئيسي', 'ldrc' ), 'textarea' );
	$add( 'ldrc_hero', 'hero_text', __( 'النص', 'ldrc' ), 'textarea' );
	$add( 'ldrc_hero', 'hero_image', __( 'صورة الخلفية', 'ldrc' ), 'image' );
	$add( 'ldrc_hero', 'hero_btn1_text', __( 'نص الزر الأول', 'ldrc' ) );
	$add( 'ldrc_hero', 'hero_btn1_url', __( 'رابط الزر الأول', 'ldrc' ), 'text' );
	$add( 'ldrc_hero', 'hero_btn2_text', __( 'نص الزر الثاني', 'ldrc' ) );
	$add( 'ldrc_hero', 'hero_btn2_url', __( 'رابط الزر الثاني (اتركه فارغاً لصفحة الأبحاث)', 'ldrc' ), 'text' );

	$add( 'ldrc_about', 'about_title', __( 'العنوان', 'ldrc' ) );
	$add( 'ldrc_about', 'about_text', __( 'النص التعريفي', 'ldrc' ), 'textarea' );
	$add( 'ldrc_about', 'about_image', __( 'صورة', 'ldrc' ), 'image' );
	$add( 'ldrc_about', 'about_vision', __( 'الرؤية', 'ldrc' ), 'textarea' );
	$add( 'ldrc_about', 'about_mission', __( 'الرسالة', 'ldrc' ), 'textarea' );

	for ( $n = 1; $n <= 4; $n++ ) {
		/* translators: %d: number */
		$add( 'ldrc_stats', "stat{$n}_num", sprintf( __( 'الرقم %d', 'ldrc' ), $n ) );
		/* translators: %d: number */
		$add( 'ldrc_stats', "stat{$n}_label", sprintf( __( 'وصف الرقم %d', 'ldrc' ), $n ) );
		/* translators: %d: number */
		$add( 'ldrc_areas', "area{$n}_title", sprintf( __( 'عنوان المجال %d', 'ldrc' ), $n ) );
		/* translators: %d: number */
		$add( 'ldrc_areas', "area{$n}_text", sprintf( __( 'وصف المجال %d', 'ldrc' ), $n ), 'textarea' );
	}

	$add( 'ldrc_contact', 'contact_address', __( 'العنوان', 'ldrc' ) );
	$add( 'ldrc_contact', 'contact_phone', __( 'الهاتف', 'ldrc' ) );
	$add( 'ldrc_contact', 'contact_email', __( 'البريد الإلكتروني', 'ldrc' ), 'email' );
	$add( 'ldrc_contact', 'contact_hours', __( 'أوقات العمل', 'ldrc' ) );
	$add( 'ldrc_contact', 'contact_map', __( 'رابط خريطة Google (رابط التضمين embed)', 'ldrc' ), 'url' );
	$add( 'ldrc_contact', 'contact_to', __( 'بريد استقبال رسائل النموذج (افتراضياً بريد المدير)', 'ldrc' ), 'email' );

	$add( 'ldrc_social', 'social_facebook', 'Facebook', 'url' );
	$add( 'ldrc_social', 'social_instagram', 'Instagram', 'url' );
	$add( 'ldrc_social', 'social_x', 'X (Twitter)', 'url' );
	$add( 'ldrc_social', 'social_linkedin', 'LinkedIn', 'url' );
	$add( 'ldrc_social', 'social_youtube', 'YouTube', 'url' );

	$add( 'ldrc_footer', 'footer_about', __( 'نبذة في التذييل', 'ldrc' ), 'textarea' );
}
add_action( 'customize_register', 'ldrc_customize_register' );

/**
 * CSS variables from customizer colors.
 *
 * @return string
 */
function ldrc_customizer_css() {
	$primary = sanitize_hex_color( ldrc_mod( 'color_primary' ) );
	$accent  = sanitize_hex_color( ldrc_mod( 'color_accent' ) );
	$dark    = sanitize_hex_color( ldrc_mod( 'color_dark' ) );
	return sprintf(
		':root{--c-primary:%1$s;--c-accent:%2$s;--c-dark:%3$s;}',
		$primary ? $primary : '#0b6e8a',
		$accent ? $accent : '#16b3a3',
		$dark ? $dark : '#0b2533'
	);
}
