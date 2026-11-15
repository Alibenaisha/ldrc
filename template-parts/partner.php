<?php
/**
 * Partner logo tile.
 *
 * @package LDRC
 */

$ldrc_url = get_post_meta( get_the_ID(), '_ldrc_partner_url', true );
$ldrc_tag = $ldrc_url ? 'a' : 'div';
?>
<<?php echo esc_html( $ldrc_tag ); ?> class="partner"<?php echo $ldrc_url ? ' href="' . esc_url( $ldrc_url ) . '" target="_blank" rel="noopener"' : ''; // phpcs:ignore ?> title="<?php the_title_attribute(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'ldrc-logo', array( 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
	<?php else : ?>
		<span class="partner-name"><?php the_title(); ?></span>
	<?php endif; ?>
</<?php echo esc_html( $ldrc_tag ); ?>>
