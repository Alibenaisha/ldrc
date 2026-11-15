<?php
/**
 * Single post / event / conference / publication.
 *
 * @package LDRC
 */

get_header();

while ( have_posts() ) :
	the_post();
	$ldrc_type = get_post_type();
	ldrc_page_header( get_the_title() );
	?>

	<div class="section">
		<div class="container single-layout">
			<article <?php post_class( 'entry' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-media"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>

				<?php if ( 'post' === $ldrc_type ) : ?>
					<?php ldrc_card_meta(); ?>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>

				<?php if ( 'post' === $ldrc_type && has_tag() ) : ?>
					<div class="entry-tags"><?php the_tags( '', '' ); ?></div>
				<?php endif; ?>
			</article>

			<aside class="single-aside">
				<?php if ( in_array( $ldrc_type, array( 'ldrc_event', 'ldrc_conference', 'ldrc_publication' ), true ) ) : ?>
					<div class="info-box">
						<h3><?php esc_html_e( 'التفاصيل', 'ldrc' ); ?></h3>
						<?php
						$ldrc_id   = get_the_ID();
						$ldrc_rows = array();
						$ldrc_link = '';
						$ldrc_ltxt = '';

						if ( 'ldrc_event' === $ldrc_type ) {
							$ldrc_rows[] = array( 'calendar', __( 'التاريخ', 'ldrc' ), ldrc_date( get_post_meta( $ldrc_id, '_ldrc_event_date', true ) ) );
							$ldrc_rows[] = array( 'clock', __( 'الوقت', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_event_time', true ) );
							$ldrc_rows[] = array( 'pin', __( 'المكان', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_event_location', true ) );
							$ldrc_link   = get_post_meta( $ldrc_id, '_ldrc_event_link', true );
							$ldrc_ltxt   = __( 'سجّل الآن', 'ldrc' );
						} elseif ( 'ldrc_conference' === $ldrc_type ) {
							$ldrc_rows[] = array( 'calendar', __( 'من', 'ldrc' ), ldrc_date( get_post_meta( $ldrc_id, '_ldrc_conf_start', true ) ) );
							$ldrc_rows[] = array( 'calendar', __( 'إلى', 'ldrc' ), ldrc_date( get_post_meta( $ldrc_id, '_ldrc_conf_end', true ) ) );
							$ldrc_rows[] = array( 'pin', __( 'المكان', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_conf_location', true ) );
							$ldrc_link   = get_post_meta( $ldrc_id, '_ldrc_conf_link', true );
							$ldrc_ltxt   = __( 'التسجيل / موقع المؤتمر', 'ldrc' );
						} else {
							$ldrc_rows[] = array( 'users', __( 'الباحثون', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_pub_authors', true ) );
							$ldrc_rows[] = array( 'book', __( 'جهة النشر', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_pub_journal', true ) );
							$ldrc_rows[] = array( 'calendar', __( 'السنة', 'ldrc' ), get_post_meta( $ldrc_id, '_ldrc_pub_year', true ) );
							$ldrc_areas  = get_the_term_list( $ldrc_id, 'ldrc_research_area', '', '، ' );
							$ldrc_link   = get_post_meta( $ldrc_id, '_ldrc_pub_file', true );
							$ldrc_ltxt   = __( 'تحميل الملف / البيانات', 'ldrc' );
						}
						?>
						<ul class="info-list">
							<?php foreach ( $ldrc_rows as $ldrc_row ) : ?>
								<?php if ( $ldrc_row[2] ) : ?>
									<li><?php echo ldrc_icon( $ldrc_row[0] ); // phpcs:ignore ?><span><small><?php echo esc_html( $ldrc_row[1] ); ?></small><?php echo esc_html( $ldrc_row[2] ); ?></span></li>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if ( ! empty( $ldrc_areas ) && ! is_wp_error( $ldrc_areas ) ) : ?>
								<li><?php echo ldrc_icon( 'flask' ); // phpcs:ignore ?><span><small><?php esc_html_e( 'المجال', 'ldrc' ); ?></small><?php echo wp_kses_post( $ldrc_areas ); ?></span></li>
							<?php endif; ?>
						</ul>
						<?php if ( $ldrc_link ) : ?>
							<a class="btn btn--primary btn--block" href="<?php echo esc_url( $ldrc_link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ldrc_ltxt ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				$ldrc_related = new WP_Query(
					array(
						'post_type'      => $ldrc_type,
						'posts_per_page' => 3,
						'post__not_in'   => array( get_the_ID() ),
					)
				);
				if ( $ldrc_related->have_posts() ) :
					?>
					<div class="info-box">
						<h3><?php esc_html_e( 'قد يهمك أيضاً', 'ldrc' ); ?></h3>
						<ul class="related">
							<?php
							while ( $ldrc_related->have_posts() ) :
								$ldrc_related->the_post();
								?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</ul>
					</div>
				<?php endif; ?>
			</aside>
		</div>
	</div>

	<?php
endwhile;

get_footer();
