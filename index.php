<?php
/**
 * Fallback template — news listing and generic archives.
 *
 * @package LDRC
 */

get_header();

if ( is_home() ) {
	$ldrc_title = get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'الأخبار', 'ldrc' );
	ldrc_page_header( $ldrc_title, ldrc_archive_subtitle( 'post' ) );
} elseif ( is_search() ) {
	/* translators: %s: search query */
	ldrc_page_header( sprintf( __( 'نتائج البحث عن: %s', 'ldrc' ), get_search_query() ) );
} elseif ( is_post_type_archive() ) {
	ldrc_page_header( post_type_archive_title( '', false ), ldrc_archive_subtitle( get_query_var( 'post_type' ) ) );
} elseif ( is_archive() ) {
	ldrc_page_header( wp_strip_all_tags( get_the_archive_title() ), wp_strip_all_tags( get_the_archive_description() ) );
} else {
	ldrc_page_header( get_bloginfo( 'name' ) );
}
?>

<div class="section">
	<div class="container">
		<?php if ( is_search() ) : ?>
			<div class="search-wrap"><?php get_search_form(); ?></div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card' );
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => __( 'السابق', 'ldrc' ),
					'next_text' => __( 'التالي', 'ldrc' ),
				)
			);
			?>
		<?php else : ?>
			<div class="empty-state">
				<span><?php echo ldrc_icon( 'search' ); // phpcs:ignore ?></span>
				<h2><?php esc_html_e( 'لا يوجد محتوى بعد', 'ldrc' ); ?></h2>
				<p><?php esc_html_e( 'لم تتم إضافة عناصر في هذا القسم حتى الآن.', 'ldrc' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
