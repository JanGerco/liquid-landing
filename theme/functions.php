<?php
/**
 * Liquid Landing — single-page landing theme.
 */

defined( 'ABSPATH' ) || exit;

define( 'LL_VERSION', '1.0.0' );
define( 'LL_DIR', get_template_directory() );
define( 'LL_URI', get_template_directory_uri() );

require LL_DIR . '/inc/i18n.php';
require LL_DIR . '/inc/portfolio.php';
require LL_DIR . '/inc/contact.php';

/* ---------- Setup ---------- */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', [ 'search-form', 'script', 'style' ] );
	remove_theme_support( 'widgets-block-editor' );
} );

add_filter( 'document_title_parts', function ( $parts ) {
	$parts['title']   = 'Studio Name';
	$parts['tagline'] = ll_t( 'meta.tagline' );
	return $parts;
} );

add_filter( 'language_attributes', function ( $output ) {
	return 'lang="' . esc_attr( ll_lang() ) . '" data-theme="dark" data-density="touch"';
} );

/* ---------- Assets ---------- */

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'll-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@700&family=Poppins:wght@400;600&display=swap', [], null );
	wp_enqueue_style( 'll-tokens', LL_URI . '/assets/css/tokens.css', [], LL_VERSION );
	wp_enqueue_style( 'll-theme', LL_URI . '/assets/css/theme.css', [ 'll-tokens' ], LL_VERSION );
	wp_enqueue_script( 'll-main', LL_URI . '/assets/js/main.js', [], LL_VERSION, [ 'strategy' => 'defer' ] );
	wp_localize_script( 'll-main', 'LL', [
		'ajax'  => admin_url( 'admin-post.php' ),
		'i18n'  => [
			'sending' => ll_t( 'form.sending' ),
			'sent'    => ll_t( 'form.sent' ),
			'error'   => ll_t( 'form.error' ),
		],
	] );
} );

add_action( 'wp_head', function () {
	// Before first paint: mark JS available and decide whether the intro runs (once per session, never under reduced motion).
	echo '<script>(function(d){d.classList.add("js");var run=false;try{run=/[?&]intro\b/.test(location.search)||(!sessionStorage.getItem("ll_intro")&&!matchMedia("(prefers-reduced-motion: reduce)").matches);}catch(e){}d.classList.add(run?"intro-on":"intro-off");})(document.documentElement)</script>' . "\n";
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<meta name="description" content="' . esc_attr( ll_t( 'meta.description' ) ) . '">' . "\n";
	echo '<meta name="theme-color" content="#0C0B10">' . "\n";
	echo '<link rel="icon" href="' . esc_url( LL_URI . '/assets/img/mark.svg' ) . '" type="image/svg+xml">' . "\n";
	foreach ( [ 'ro', 'en' ] as $l ) {
		echo '<link rel="alternate" hreflang="' . $l . '" href="' . esc_url( add_query_arg( 'lang', $l, home_url( '/' ) ) ) . '">' . "\n";
	}
}, 1 );

/* ---------- Trim WordPress front-end output ---------- */

add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	add_filter( 'xmlrpc_enabled', '__return_false' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}, 20 );

/* Single page: send every front-end request to the front page (404s included). */
add_action( 'template_redirect', function () {
	if ( is_admin() || is_front_page() || is_home() || wp_doing_ajax() ) {
		return;
	}
	if ( is_404() || is_singular() || is_archive() || is_search() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

/* ---------- Helpers ---------- */

function ll_asset( string $path ): string {
	return LL_URI . '/assets/' . ltrim( $path, '/' );
}

/** Inline an SVG from assets/img so it can use currentColor. */
function ll_svg( string $name, string $attrs = '' ): string {
	$file = LL_DIR . '/assets/img/' . $name . '.svg';
	if ( ! is_readable( $file ) ) {
		return '';
	}
	$svg = file_get_contents( $file );
	return $attrs ? preg_replace( '/<svg\b/', '<svg ' . $attrs, $svg, 1 ) : $svg;
}
