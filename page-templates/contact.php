<?php
/**
 * Template Name: صفحة اتصل بنا
 *
 * @package LDRC
 */

get_header();

while ( have_posts() ) :
	the_post();
	ldrc_page_header( get_the_title(), __( 'يسعدنا تواصلكم معنا بخصوص الأبحاث والتعاون والفعاليات.', 'ldrc' ) );
	?>
	<div class="section">
		<div class="container contact-layout">
			<div class="contact-info">
				<?php if ( get_the_content() ) : ?>
					<div class="entry-content"><?php the_content(); ?></div>
				<?php endif; ?>
				<ul class="info-list info-list--big">
					<?php if ( ldrc_mod( 'contact_address' ) ) : ?>
						<li><?php echo ldrc_icon( 'pin' ); // phpcs:ignore ?><span><small><?php esc_html_e( 'العنوان', 'ldrc' ); ?></small><?php echo esc_html( ldrc_mod( 'contact_address' ) ); ?></span></li>
					<?php endif; ?>
					<?php if ( ldrc_mod( 'contact_phone' ) ) : ?>
						<li><?php echo ldrc_icon( 'phone' ); // phpcs:ignore ?><span><small><?php esc_html_e( 'الهاتف', 'ldrc' ); ?></small><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', ldrc_mod( 'contact_phone' ) ) ); ?>" dir="ltr"><?php echo esc_html( ldrc_mod( 'contact_phone' ) ); ?></a></span></li>
					<?php endif; ?>
					<?php if ( ldrc_mod( 'contact_email' ) ) : ?>
						<li><?php echo ldrc_icon( 'mail' ); // phpcs:ignore ?><span><small><?php esc_html_e( 'البريد الإلكتروني', 'ldrc' ); ?></small><a href="mailto:<?php echo esc_attr( ldrc_mod( 'contact_email' ) ); ?>"><?php echo esc_html( ldrc_mod( 'contact_email' ) ); ?></a></span></li>
					<?php endif; ?>
					<?php if ( ldrc_mod( 'contact_hours' ) ) : ?>
						<li><?php echo ldrc_icon( 'clock' ); // phpcs:ignore ?><span><small><?php esc_html_e( 'أوقات العمل', 'ldrc' ); ?></small><?php echo esc_html( ldrc_mod( 'contact_hours' ) ); ?></span></li>
					<?php endif; ?>
				</ul>
				<?php ldrc_social_links(); ?>
			</div>
			<div class="contact-form-wrap">
				<h2><?php esc_html_e( 'أرسل لنا رسالة', 'ldrc' ); ?></h2>
				<?php ldrc_contact_form(); ?>
			</div>
		</div>

		<?php if ( ldrc_mod( 'contact_map' ) ) : ?>
			<div class="container">
				<div class="map"><iframe src="<?php echo esc_url( ldrc_mod( 'contact_map' ) ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e( 'الخريطة', 'ldrc' ); ?>"></iframe></div>
			</div>
		<?php endif; ?>
	</div>
	<?php
endwhile;

get_footer();
