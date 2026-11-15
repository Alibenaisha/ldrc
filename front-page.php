<?php
/**
 * Front page.
 *
 * @package LDRC
 */

get_header();

$ldrc_hero_img = ldrc_mod( 'hero_image' );
$ldrc_btn2_url = ldrc_mod( 'hero_btn2_url' ) ? ldrc_mod( 'hero_btn2_url' ) : get_post_type_archive_link( 'ldrc_publication' );
?>

<section class="hero<?php echo $ldrc_hero_img ? ' hero--image' : ''; ?>"<?php echo $ldrc_hero_img ? ' style="--hero-img:url(' . esc_url( $ldrc_hero_img ) . ')"' : ''; ?>>
	<div class="container hero-inner">
		<div class="hero-content">
			<span class="kicker"><?php echo esc_html( ldrc_mod( 'hero_kicker' ) ); ?></span>
			<h1><?php echo esc_html( ldrc_mod( 'hero_title' ) ); ?></h1>
			<p><?php echo esc_html( ldrc_mod( 'hero_text' ) ); ?></p>
			<div class="hero-actions">
				<?php if ( ldrc_mod( 'hero_btn1_text' ) ) : ?>
					<a class="btn btn--primary" href="<?php echo esc_url( ldrc_mod( 'hero_btn1_url' ) ); ?>"><?php echo esc_html( ldrc_mod( 'hero_btn1_text' ) ); ?></a>
				<?php endif; ?>
				<?php if ( ldrc_mod( 'hero_btn2_text' ) ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( $ldrc_btn2_url ); ?>"><?php echo esc_html( ldrc_mod( 'hero_btn2_text' ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( ! $ldrc_hero_img ) : ?>
			<div class="hero-art" aria-hidden="true">
				<div class="hero-ring"></div>
				<div class="hero-ring hero-ring--2"></div>
				<span class="hero-tooth"><?php echo ldrc_icon( 'tooth' ); // phpcs:ignore ?></span>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="stats-band">
	<div class="container stats">
		<?php for ( $ldrc_i = 1; $ldrc_i <= 4; $ldrc_i++ ) : ?>
			<?php if ( ldrc_mod( "stat{$ldrc_i}_num" ) ) : ?>
				<div class="stat">
					<strong data-count="<?php echo esc_attr( preg_replace( '/[^0-9]/', '', ldrc_mod( "stat{$ldrc_i}_num" ) ) ); ?>"><?php echo esc_html( ldrc_mod( "stat{$ldrc_i}_num" ) ); ?></strong>
					<span><?php echo esc_html( ldrc_mod( "stat{$ldrc_i}_label" ) ); ?></span>
				</div>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
</section>

<section class="section" id="about">
	<div class="container about">
		<div class="about-media">
			<?php if ( ldrc_mod( 'about_image' ) ) : ?>
				<img src="<?php echo esc_url( ldrc_mod( 'about_image' ) ); ?>" alt="<?php echo esc_attr( ldrc_mod( 'about_title' ) ); ?>" loading="lazy">
			<?php else : ?>
				<div class="about-placeholder"><?php echo ldrc_icon( 'flask' ); // phpcs:ignore ?></div>
			<?php endif; ?>
		</div>
		<div class="about-text">
			<span class="kicker"><?php esc_html_e( 'من نحن', 'ldrc' ); ?></span>
			<h2><?php echo esc_html( ldrc_mod( 'about_title' ) ); ?></h2>
			<p><?php echo esc_html( ldrc_mod( 'about_text' ) ); ?></p>
			<div class="vm">
				<div class="vm-item">
					<h3><?php esc_html_e( 'رؤيتنا', 'ldrc' ); ?></h3>
					<p><?php echo esc_html( ldrc_mod( 'about_vision' ) ); ?></p>
				</div>
				<div class="vm-item">
					<h3><?php esc_html_e( 'رسالتنا', 'ldrc' ); ?></h3>
					<p><?php echo esc_html( ldrc_mod( 'about_mission' ) ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<?php ldrc_section_head( __( 'مجالات العمل', 'ldrc' ), __( 'ما الذي يعمل عليه المركز', 'ldrc' ) ); ?>
		<div class="areas">
			<?php
			$ldrc_area_icons = array( 1 => 'users', 2 => 'tooth', 3 => 'flask', 4 => 'book' );
			for ( $ldrc_i = 1; $ldrc_i <= 4; $ldrc_i++ ) :
				if ( ! ldrc_mod( "area{$ldrc_i}_title" ) ) {
					continue;
				}
				?>
				<div class="area">
					<span class="area-icon"><?php echo ldrc_icon( $ldrc_area_icons[ $ldrc_i ] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( ldrc_mod( "area{$ldrc_i}_title" ) ); ?></h3>
					<p><?php echo esc_html( ldrc_mod( "area{$ldrc_i}_text" ) ); ?></p>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php ldrc_section_head( __( 'المركز الإعلامي', 'ldrc' ), __( 'آخر الأخبار', 'ldrc' ), ldrc_posts_page_url() ); ?>
		<div class="grid grid-3">
			<?php
			$ldrc_news = new WP_Query(
				array(
					'post_type'           => 'post',
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => true,
				)
			);
			if ( $ldrc_news->have_posts() ) {
				while ( $ldrc_news->have_posts() ) {
					$ldrc_news->the_post();
					get_template_part( 'template-parts/card' );
				}
				wp_reset_postdata();
			} else {
				ldrc_placeholder_cards( __( 'الأخبار', 'ldrc' ) );
			}
			?>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<?php ldrc_section_head( __( 'الإنتاج العلمي', 'ldrc' ), __( 'الأبحاث والبيانات', 'ldrc' ), get_post_type_archive_link( 'ldrc_publication' ) ); ?>
		<div class="grid grid-3">
			<?php
			$ldrc_pubs = new WP_Query(
				array(
					'post_type'      => 'ldrc_publication',
					'posts_per_page' => 3,
				)
			);
			if ( $ldrc_pubs->have_posts() ) {
				while ( $ldrc_pubs->have_posts() ) {
					$ldrc_pubs->the_post();
					get_template_part( 'template-parts/card' );
				}
				wp_reset_postdata();
			} else {
				ldrc_placeholder_cards( __( 'الأبحاث', 'ldrc' ) );
			}
			?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container two-col">
		<div>
			<?php ldrc_section_head( __( 'الأنشطة', 'ldrc' ), __( 'الفعاليات', 'ldrc' ), get_post_type_archive_link( 'ldrc_event' ) ); ?>
			<div class="list">
				<?php
				$ldrc_events = ldrc_front_dated_query( 'ldrc_event', '_ldrc_event_date' );
				if ( $ldrc_events->have_posts() ) :
					while ( $ldrc_events->have_posts() ) :
						$ldrc_events->the_post();
						$ldrc_d = get_post_meta( get_the_ID(), '_ldrc_event_date', true );
						?>
						<a class="list-item" href="<?php the_permalink(); ?>">
							<span class="date-badge">
								<strong><?php echo esc_html( $ldrc_d ? ldrc_date( $ldrc_d, 'j' ) : '–' ); ?></strong>
								<small><?php echo esc_html( $ldrc_d ? ldrc_date( $ldrc_d, 'F' ) : '' ); ?></small>
							</span>
							<span class="list-text">
								<strong><?php the_title(); ?></strong>
								<?php if ( get_post_meta( get_the_ID(), '_ldrc_event_location', true ) ) : ?>
									<small><?php echo ldrc_icon( 'pin' ); // phpcs:ignore ?><?php echo esc_html( get_post_meta( get_the_ID(), '_ldrc_event_location', true ) ); ?></small>
								<?php endif; ?>
							</span>
						</a>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="empty"><?php esc_html_e( 'لا توجد فعاليات حالياً. سيتم الإعلان عن الفعاليات القادمة هنا.', 'ldrc' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<div>
			<?php ldrc_section_head( __( 'اللقاءات العلمية', 'ldrc' ), __( 'المؤتمرات', 'ldrc' ), get_post_type_archive_link( 'ldrc_conference' ) ); ?>
			<div class="list">
				<?php
				$ldrc_confs = ldrc_front_dated_query( 'ldrc_conference', '_ldrc_conf_start' );
				if ( $ldrc_confs->have_posts() ) :
					while ( $ldrc_confs->have_posts() ) :
						$ldrc_confs->the_post();
						$ldrc_d = get_post_meta( get_the_ID(), '_ldrc_conf_start', true );
						?>
						<a class="list-item" href="<?php the_permalink(); ?>">
							<span class="date-badge date-badge--accent">
								<strong><?php echo esc_html( $ldrc_d ? ldrc_date( $ldrc_d, 'j' ) : '–' ); ?></strong>
								<small><?php echo esc_html( $ldrc_d ? ldrc_date( $ldrc_d, 'F' ) : '' ); ?></small>
							</span>
							<span class="list-text">
								<strong><?php the_title(); ?></strong>
								<?php if ( get_post_meta( get_the_ID(), '_ldrc_conf_location', true ) ) : ?>
									<small><?php echo ldrc_icon( 'pin' ); // phpcs:ignore ?><?php echo esc_html( get_post_meta( get_the_ID(), '_ldrc_conf_location', true ) ); ?></small>
								<?php endif; ?>
							</span>
						</a>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="empty"><?php esc_html_e( 'لا توجد مؤتمرات حالياً. سيتم الإعلان عن المؤتمرات القادمة هنا.', 'ldrc' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<?php ldrc_section_head( __( 'شركاء النجاح', 'ldrc' ), __( 'شركاؤنا', 'ldrc' ), get_post_type_archive_link( 'ldrc_partner' ) ); ?>
		<div class="partners">
			<?php
			$ldrc_partners = new WP_Query(
				array(
					'post_type'      => 'ldrc_partner',
					'posts_per_page' => 12,
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
				)
			);
			if ( $ldrc_partners->have_posts() ) {
				while ( $ldrc_partners->have_posts() ) {
					$ldrc_partners->the_post();
					get_template_part( 'template-parts/partner' );
				}
				wp_reset_postdata();
			} else {
				for ( $ldrc_i = 1; $ldrc_i <= 6; $ldrc_i++ ) {
					/* translators: %d: number */
					echo '<div class="partner partner--placeholder"><span class="partner-name">' . esc_html( sprintf( __( 'شريك %d', 'ldrc' ), $ldrc_i ) ) . '</span></div>';
				}
			}
			?>
		</div>
	</div>
</section>

<section class="cta" id="contact">
	<div class="container cta-inner">
		<div>
			<h2><?php esc_html_e( 'هل لديك مشروع بحثي أو ترغب في التعاون معنا؟', 'ldrc' ); ?></h2>
			<p><?php esc_html_e( 'نرحب بالباحثين والمؤسسات والجهات الراغبة في الشراكة ودعم البحث العلمي في طب الأسنان.', 'ldrc' ); ?></p>
		</div>
		<a class="btn btn--light" href="<?php echo esc_url( ldrc_contact_url() ); ?>"><?php esc_html_e( 'تواصل معنا', 'ldrc' ); ?></a>
	</div>
</section>

<?php
get_footer();
