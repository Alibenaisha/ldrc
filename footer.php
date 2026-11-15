<?php
/**
 * Footer.
 *
 * @package LDRC
 */

?>
</main>

<footer class="site-footer">
	<div class="container footer-grid">
		<div class="footer-col footer-about">
			<a class="brand-text brand-text--light" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="brand-mark"><?php echo ldrc_icon( 'tooth' ); // phpcs:ignore ?></span>
				<strong><?php bloginfo( 'name' ); ?></strong>
			</a>
			<p><?php echo esc_html( ldrc_mod( 'footer_about' ) ); ?></p>
			<?php ldrc_social_links(); ?>
		</div>

		<div class="footer-col">
			<h4><?php esc_html_e( 'روابط سريعة', 'ldrc' ); ?></h4>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => 'ldrc_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
		</div>

		<div class="footer-col">
			<h4><?php esc_html_e( 'تواصل معنا', 'ldrc' ); ?></h4>
			<ul class="contact-list">
				<?php if ( ldrc_mod( 'contact_address' ) ) : ?>
					<li><?php echo ldrc_icon( 'pin' ); // phpcs:ignore ?><span><?php echo esc_html( ldrc_mod( 'contact_address' ) ); ?></span></li>
				<?php endif; ?>
				<?php if ( ldrc_mod( 'contact_phone' ) ) : ?>
					<li><?php echo ldrc_icon( 'phone' ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( ldrc_mod( 'contact_phone' ) ); ?></span></li>
				<?php endif; ?>
				<?php if ( ldrc_mod( 'contact_email' ) ) : ?>
					<li><?php echo ldrc_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( ldrc_mod( 'contact_email' ) ); ?>"><?php echo esc_html( ldrc_mod( 'contact_email' ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( ldrc_mod( 'contact_hours' ) ) : ?>
					<li><?php echo ldrc_icon( 'clock' ); // phpcs:ignore ?><span><?php echo esc_html( ldrc_mod( 'contact_hours' ) ); ?></span></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'جميع الحقوق محفوظة.', 'ldrc' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
