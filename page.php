<?php
/**
 * Default page.
 *
 * @package LDRC
 */

get_header();

while ( have_posts() ) :
	the_post();
	ldrc_page_header( get_the_title() );
	?>
	<div class="section">
		<div class="container container--narrow">
			<article <?php post_class( 'entry' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-media"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
			</article>
		</div>
	</div>
	<?php
endwhile;

get_footer();
