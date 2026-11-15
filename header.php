<?php
/**
 * Header.
 *
 * @package LDRC
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'تخطي إلى المحتوى', 'ldrc' ); ?></a>

<div class="topbar">
	<div class="container topbar-inner">
		<div class="topbar-info">
			<?php if ( ldrc_mod( 'contact_phone' ) ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', ldrc_mod( 'contact_phone' ) ) ); ?>" dir="ltr"><?php echo ldrc_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( ldrc_mod( 'contact_phone' ) ); ?></a>
			<?php endif; ?>
			<?php if ( ldrc_mod( 'contact_email' ) ) : ?>
				<a href="mailto:<?php echo esc_attr( ldrc_mod( 'contact_email' ) ); ?>"><?php echo ldrc_icon( 'mail' ); // phpcs:ignore ?><?php echo esc_html( ldrc_mod( 'contact_email' ) ); ?></a>
			<?php endif; ?>
		</div>
		<?php ldrc_social_links(); ?>
	</div>
</div>

<header class="site-header" id="site-header">
	<div class="container header-inner">
		<div class="brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="brand-mark"><?php echo ldrc_icon( 'tooth' ); // phpcs:ignore ?></span>
					<span>
						<strong><?php bloginfo( 'name' ); ?></strong>
						<?php if ( get_bloginfo( 'description' ) ) : ?>
							<small><?php bloginfo( 'description' ); ?></small>
						<?php endif; ?>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false">
			<span class="screen-reader-text"><?php esc_html_e( 'القائمة', 'ldrc' ); ?></span>
			<?php echo ldrc_icon( 'menu' ); // phpcs:ignore ?>
		</button>

		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'القائمة الرئيسية', 'ldrc' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => 'ldrc_menu_fallback',
					'depth'          => 2,
				)
			);
			?>
			<a class="btn btn--primary btn--sm nav-cta" href="<?php echo esc_url( ldrc_contact_url() ); ?>"><?php esc_html_e( 'تواصل معنا', 'ldrc' ); ?></a>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
