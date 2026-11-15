<?php
/**
 * Search form.
 *
 * @package LDRC
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s-<?php echo esc_attr( wp_unique_id() ); ?>"><?php esc_html_e( 'بحث', 'ldrc' ); ?></label>
	<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'ابحث في الموقع…', 'ldrc' ); ?>">
	<button type="submit" aria-label="<?php esc_attr_e( 'بحث', 'ldrc' ); ?>"><?php echo ldrc_icon( 'search' ); // phpcs:ignore ?></button>
</form>
