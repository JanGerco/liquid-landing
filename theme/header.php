<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="intro" id="intro" aria-hidden="true">
	<svg class="intro__mark" viewBox="0 0 100 100" width="140" height="140" focusable="false">
		<defs>
			<linearGradient id="intro-g" gradientUnits="userSpaceOnUse" x1="73" y1="27" x2="27" y2="73">
				<stop offset="0" stop-color="#2A10F5"/><stop offset=".55" stop-color="#E23CF0"/><stop offset="1" stop-color="#FF6A63"/>
			</linearGradient>
		</defs>
		<path class="intro__ribbon" d="M73 27 C64 50 36 50 27 73" fill="none" stroke="url(#intro-g)" stroke-width="22" pathLength="100"/>
		<path class="intro__dot intro__dot--top" d="M25 19 H75" pathLength="100"/>
		<path class="intro__dot intro__dot--bottom" d="M25 81 H75" pathLength="100"/>
	</svg>
</div>

<a class="skip-link" href="#main"><?php ll_e( 'nav.skip' ); ?></a>

<header class="site-header" id="top">
	<div class="site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Studio Name">
			<?php echo ll_svg( 'mark', 'class="brand__mark"' ); ?>
			<span class="brand__name">Studio</span>
		</a>

		<button type="button" class="menu-toggle" aria-expanded="false" aria-controls="site-nav" data-label-close="<?php echo esc_attr( ll_t( 'nav.close' ) ); ?>">
			<?php ll_e( 'nav.menu' ); ?>
		</button>

		<nav class="site-nav" id="site-nav" aria-label="Primary">
			<a href="#about"><?php ll_e( 'nav.about' ); ?></a>
			<a href="#services"><?php ll_e( 'nav.services' ); ?></a>
			<a href="#work"><?php ll_e( 'nav.work' ); ?></a>
			<a href="#contact"><?php ll_e( 'nav.contact' ); ?></a>
			<a class="site-nav__cta btn btn--filled" href="#contact"><?php ll_e( 'nav.cta' ); ?></a>
		</nav>

		<div class="site-header__actions">
			<a class="lang" href="<?php echo esc_url( add_query_arg( 'lang', ll_other_lang(), home_url( '/' ) ) ); ?>" hreflang="<?php echo esc_attr( ll_other_lang() ); ?>" lang="<?php echo esc_attr( ll_other_lang() ); ?>" aria-label="<?php echo esc_attr( ll_t( 'nav.lang_aria' ) ); ?>"><?php ll_e( 'nav.lang' ); ?></a>
			<a class="btn btn--tinted" href="#contact"><?php ll_e( 'nav.cta' ); ?></a>
		</div>
	</div>
</header>

<main id="main" class="site-main">
