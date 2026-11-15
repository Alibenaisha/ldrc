<?php
/**
 * Generic card used for news, events, conferences and publications.
 *
 * @package LDRC
 */

$ldrc_type     = get_post_type();
$ldrc_upcoming = in_array( $ldrc_type, array( 'ldrc_event', 'ldrc_conference' ), true ) && ldrc_is_upcoming();
?>
<article <?php post_class( 'card' ); ?>>
	<a class="card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ldrc-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span><?php echo ldrc_icon( 'ldrc_publication' === $ldrc_type ? 'file' : 'tooth' ); // phpcs:ignore ?></span>
		<?php endif; ?>
		<?php if ( $ldrc_upcoming ) : ?>
			<em class="badge"><?php esc_html_e( 'قادم', 'ldrc' ); ?></em>
		<?php endif; ?>
	</a>
	<div class="card-body">
		<?php ldrc_card_meta(); ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_excerpt() || get_the_content() ) : ?>
			<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></p>
		<?php endif; ?>
		<a class="link-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'اقرأ المزيد', 'ldrc' ); ?> <?php echo ldrc_icon( 'arrow' ); // phpcs:ignore ?></a>
	</div>
</article>
