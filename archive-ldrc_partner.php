<?php
/**
 * Partners archive — logo wall.
 *
 * @package LDRC
 */

get_header();
ldrc_page_header( post_type_archive_title( '', false ), ldrc_archive_subtitle( 'ldrc_partner' ) );
?>

<div class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="partners partners--page">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/partner' );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<div class="empty-state">
				<span><?php echo ldrc_icon( 'users' ); // phpcs:ignore ?></span>
				<h2><?php esc_html_e( 'سيتم إضافة الشركاء قريباً', 'ldrc' ); ?></h2>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
