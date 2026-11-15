<?php
/**
 * 404.
 *
 * @package LDRC
 */

get_header();
ldrc_page_header( __( 'الصفحة غير موجودة', 'ldrc' ) );
?>
<div class="section">
	<div class="container container--narrow">
		<div class="empty-state">
			<span><?php echo ldrc_icon( 'tooth' ); // phpcs:ignore ?></span>
			<h2>404</h2>
			<p><?php esc_html_e( 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.', 'ldrc' ); ?></p>
			<div class="search-wrap"><?php get_search_form(); ?></div>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'العودة للرئيسية', 'ldrc' ); ?></a>
		</div>
	</div>
</div>
<?php
get_footer();
