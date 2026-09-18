<?php
/**
 * Contact form: POST to admin-post.php?action=ll_contact.
 * With JS the request carries Accept: application/json and gets a JSON reply;
 * without JS it redirects back to #contact with ?sent=1 or ?error=<field|send>.
 */

defined( 'ABSPATH' ) || exit;

/** Messages go to Settings → General → Administration Email. */
function ll_contact_to(): string {
	return (string) get_option( 'admin_email' );
}

add_action( 'admin_post_nopriv_ll_contact', 'll_contact_handle' );
add_action( 'admin_post_ll_contact', 'll_contact_handle' );

function ll_contact_handle(): void {
	$wants_json = false !== strpos( $_SERVER['HTTP_ACCEPT'] ?? '', 'application/json' );

	$fail = static function ( string $code, string $message ) use ( $wants_json ): void {
		if ( $wants_json ) {
			wp_send_json( [ 'ok' => false, 'field' => $code, 'message' => $message ], 422 );
		}
		wp_safe_redirect( add_query_arg( 'error', $code, home_url( '/' ) ) . '#contact' );
		exit;
	};

	if ( ! wp_verify_nonce( $_POST['_ll_nonce'] ?? '', 'll_contact' ) ) {
		$fail( 'send', ll_t( 'form.error' ) );
	}

	// Honeypot: real people never fill this.
	if ( ! empty( $_POST['website'] ) ) {
		$fail( 'send', ll_t( 'form.error' ) );
	}

	// Rate limit: one message per IP per minute.
	$ip  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	$key = 'll_contact_' . md5( $ip );
	if ( get_transient( $key ) ) {
		$fail( 'send', ll_t( 'form.error' ) );
	}

	$name    = trim( sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$message = trim( sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ) );

	if ( $name === '' || mb_strlen( $name ) > 120 ) {
		$fail( 'name', ll_t( 'form.err_name' ) );
	}
	if ( ! is_email( $email ) ) {
		$fail( 'email', ll_t( 'form.err_email' ) );
	}
	if ( mb_strlen( $message ) < 10 || mb_strlen( $message ) > 5000 ) {
		$fail( 'message', ll_t( 'form.err_message' ) );
	}

	$subject = sprintf( '[%s] %s', wp_parse_url( home_url(), PHP_URL_HOST ), $name );
	$body    = "Nume: $name\nEmail: $email\nIP: $ip\n\n$message\n";
	$headers = [
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	];

	$sent = wp_mail( ll_contact_to(), $subject, $body, $headers );
	if ( ! $sent ) {
		$fail( 'send', ll_t( 'form.error' ) );
	}

	set_transient( $key, 1, MINUTE_IN_SECONDS );

	if ( $wants_json ) {
		wp_send_json( [ 'ok' => true, 'message' => ll_t( 'form.sent' ) ] );
	}
	wp_safe_redirect( add_query_arg( 'sent', '1', home_url( '/' ) ) . '#contact' );
	exit;
}
