<?php
/**
 * Contact form handler (no plugin needed).
 *
 * @package LDRC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle form submission via admin-post.php.
 */
function ldrc_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'sent', $back );

	if ( ! isset( $_POST['ldrc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ldrc_contact_nonce'] ), 'ldrc_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $back ) . '#contact-form' );
		exit;
	}

	// Honeypot: bots fill hidden fields.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'ok', $back ) . '#contact-form' );
		exit;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', 'invalid', $back ) . '#contact-form' );
		exit;
	}

	$to = ldrc_mod( 'contact_to' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	/* translators: %s: subject */
	$mail_subject = sprintf( __( '[موقع المركز] %s', 'ldrc' ), $subject ? $subject : __( 'رسالة جديدة', 'ldrc' ) );
	$body         = sprintf(
		"%s: %s\n%s: %s\n%s: %s\n\n%s",
		__( 'الاسم', 'ldrc' ),
		$name,
		__( 'البريد', 'ldrc' ),
		$email,
		__( 'الهاتف', 'ldrc' ),
		$phone,
		$message
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$ok = wp_mail( $to, $mail_subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'sent', $ok ? 'ok' : 'error', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_ldrc_contact', 'ldrc_handle_contact' );
add_action( 'admin_post_ldrc_contact', 'ldrc_handle_contact' );

/**
 * Render the contact form.
 */
function ldrc_contact_form() {
	$status = isset( $_GET['sent'] ) ? sanitize_key( $_GET['sent'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$notes  = array(
		'ok'      => array( 'success', __( 'تم إرسال رسالتك بنجاح، سنتواصل معك قريباً.', 'ldrc' ) ),
		'invalid' => array( 'error', __( 'الرجاء تعبئة الاسم والبريد الإلكتروني والرسالة بشكل صحيح.', 'ldrc' ) ),
		'error'   => array( 'error', __( 'تعذر إرسال الرسالة، حاول مرة أخرى أو راسلنا عبر البريد.', 'ldrc' ) ),
	);
	?>
	<form id="contact-form" class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( isset( $notes[ $status ] ) ) : ?>
			<div class="notice notice--<?php echo esc_attr( $notes[ $status ][0] ); ?>"><?php echo esc_html( $notes[ $status ][1] ); ?></div>
		<?php endif; ?>
		<input type="hidden" name="action" value="ldrc_contact">
		<?php wp_nonce_field( 'ldrc_contact', 'ldrc_contact_nonce' ); ?>
		<div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
		<div class="form-grid">
			<label><?php esc_html_e( 'الاسم الكامل', 'ldrc' ); ?> *<input type="text" name="name" required></label>
			<label><?php esc_html_e( 'البريد الإلكتروني', 'ldrc' ); ?> *<input type="email" name="email" required dir="ltr"></label>
			<label><?php esc_html_e( 'رقم الهاتف', 'ldrc' ); ?><input type="tel" name="phone" dir="ltr"></label>
			<label><?php esc_html_e( 'الموضوع', 'ldrc' ); ?><input type="text" name="subject"></label>
			<label class="full"><?php esc_html_e( 'الرسالة', 'ldrc' ); ?> *<textarea name="message" rows="6" required></textarea></label>
		</div>
		<button type="submit" class="btn btn--primary"><?php esc_html_e( 'إرسال الرسالة', 'ldrc' ); ?></button>
	</form>
	<?php
}
