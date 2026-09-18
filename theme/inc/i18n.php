<?php
/**
 * Two-language strings (RO default, EN) chosen by ?lang= and remembered in a cookie.
 * Replace the placeholder copy below with your own; keep the keys.
 */

defined( 'ABSPATH' ) || exit;

const LL_LANGS  = [ 'ro', 'en' ];
const LL_COOKIE = 'll_lang';

function ll_lang(): string {
	static $lang = null;
	if ( $lang !== null ) {
		return $lang;
	}
	$req = isset( $_GET['lang'] ) ? sanitize_key( $_GET['lang'] ) : '';
	if ( in_array( $req, LL_LANGS, true ) ) {
		$lang = $req;
		if ( ! headers_sent() ) {
			setcookie( LL_COOKIE, $lang, [ 'expires' => time() + YEAR_IN_SECONDS, 'path' => '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ] );
		}
		return $lang;
	}
	$cookie = isset( $_COOKIE[ LL_COOKIE ] ) ? sanitize_key( $_COOKIE[ LL_COOKIE ] ) : '';
	$lang   = in_array( $cookie, LL_LANGS, true ) ? $cookie : 'ro';
	return $lang;
}

function ll_other_lang(): string {
	return ll_lang() === 'ro' ? 'en' : 'ro';
}

/** Translate a key. Missing keys fall back to RO, then to the key itself. */
function ll_t( string $key ): string {
	$all = ll_strings();
	$l   = ll_lang();
	return $all[ $l ][ $key ] ?? $all['ro'][ $key ] ?? $key;
}

/** Echo an escaped translation. Keys ending in `_html` allow <strong>, <em> and <br>. */
function ll_e( string $key ): void {
	$v = ll_t( $key );
	echo substr( $key, -5 ) === '_html' ? wp_kses( $v, [ 'strong' => [], 'br' => [], 'em' => [] ] ) : esc_html( $v );
}

function ll_strings(): array {
	static $s = null;
	if ( $s ) {
		return $s;
	}
	$s = [];

	$s['ro'] = [
		'meta.tagline'     => 'Studio digital: web, design, marketing',
		'meta.description' => 'Studio digital care construiește site-uri rapide, clare și orientate spre rezultate.',

		'nav.about'     => 'Despre',
		'nav.services'  => 'Servicii',
		'nav.work'      => 'Proiecte',
		'nav.contact'   => 'Contact',
		'nav.cta'       => 'Scrie-ne',
		'nav.lang'      => 'EN',
		'nav.lang_aria' => 'Switch to English',
		'nav.skip'      => 'Sari la conținut',
		'nav.menu'      => 'Meniu',
		'nav.close'     => 'Închide',

		'hero.title_html' => 'Numele<br>Studioului',
		'hero.quote'      => '„Design is the silent ambassador of your brand.”',
		'hero.quote_by'   => 'Paul Rand',
		'hero.lead'       => 'O propoziție care spune ce faceți și pentru cine, fără jargon.',
		'hero.cta'        => 'Vezi proiectele',
		'hero.cta2'       => 'Discută un proiect',

		'about.title'   => 'Despre',
		'about.p1_html' => '<strong>Numele Studioului</strong> este un <strong>studio digital</strong> specializat în <strong>dezvoltare web</strong>, <strong>design</strong> și <strong>marketing</strong>.',
		'about.p2_html' => 'Construim site-uri <strong>rapide</strong> și <strong>ușor de folosit</strong>, care <strong>aduc rezultate</strong>.',
		'about.p3_html' => 'Fiecare proiect pornește de la <strong>nevoile afacerii tale</strong>, nu de la un șablon.',

		'why.title_html' => 'De ce<br>contează<br>calitatea?',
		'why.s1_html'    => 'Dintre utilizatori judecă <strong>credibilitatea</strong> unei companii după <strong>designul site-ului</strong>.',
		'why.s2_html'    => 'Dintre utilizatori nu ar <strong>recomanda</strong> o afacere cu un <strong>site slab realizat</strong>.',
		'why.s3_html'    => 'Dintre utilizatori spun că <strong>designul</strong> este <strong>principalul motiv</strong> pentru care <strong>resping</strong> un site.',

		'services.title'    => 'Servicii',
		'services.g1'       => 'Web & design',
		'services.g2'       => 'Creștere & suport',
		'services.1.t'      => 'Dezvoltare web',
		'services.1.d_html' => 'Site-uri <strong>personalizate</strong> și <strong>performante</strong>.',
		'services.2.t'      => 'Design UX/UI',
		'services.2.d_html' => 'Experiențe <strong>intuitive</strong> și <strong>atractive</strong>.',
		'services.3.t'      => 'E-commerce',
		'services.3.d_html' => 'Magazine online <strong>scalabile</strong>.',
		'services.4.t'      => 'Branding',
		'services.4.d_html' => '<strong>Identitate</strong> vizuală <strong>coerentă</strong>.',
		'services.5.t'      => 'SEO & marketing',
		'services.5.d_html' => '<strong>Vizibilitate</strong> și <strong>trafic</strong> care contează.',
		'services.6.t'      => 'Mentenanță',
		'services.6.d_html' => '<strong>Actualizări</strong>, <strong>securitate</strong>, <strong>performanță</strong>.',

		'vision.1.t'      => 'Viziune',
		'vision.1.d_html' => 'Un paragraf scurt despre <strong>direcția</strong> în care mergeți și <strong>impactul</strong> pe care vreți să-l aveți.',
		'vision.2.t'      => 'Misiune',
		'vision.2.d_html' => 'Un paragraf scurt despre <strong>cum</strong> lucrați și <strong>ce</strong> promiteți fiecărui client.',
		'vision.3.t'      => 'Suport',
		'vision.3.d_html' => 'Un paragraf scurt despre <strong>ce se întâmplă după lansare</strong>: suport, optimizare, actualizări.',

		'work.title' => 'Proiecte',
		'work.lead'  => 'O selecție din proiectele realizate.',
		'work.more'  => 'Arată toate proiectele',
		'work.alt'   => 'Captură de ecran a site-ului',

		'contact.title'    => 'Scrie-ne',
		'contact.lead'     => 'Spune-ne despre proiectul tău și revenim în cel mult o zi lucrătoare.',
		'contact.phone'    => 'Telefon',
		'contact.email'    => 'Email',
		'form.name'        => 'Nume',
		'form.email'       => 'Email',
		'form.message'     => 'Mesaj',
		'form.message_ph'  => 'Ce vrei să construim împreună?',
		'form.submit'      => 'Trimite mesajul',
		'form.sending'     => 'Se trimite…',
		'form.sent'        => 'Mesaj trimis. Revenim în curând.',
		'form.error'       => 'Mesajul nu a putut fi trimis. Încearcă din nou sau scrie-ne pe email.',
		'form.err_name'    => 'Scrie numele tău.',
		'form.err_email'   => 'Scrie o adresă de email validă, de forma nume@exemplu.ro.',
		'form.err_message' => 'Scrie un mesaj de cel puțin 10 caractere.',

		'footer.thanks' => 'Mulțumim.',
		'footer.rights' => 'Toate drepturile rezervate.',
	];

	$s['en'] = [
		'meta.tagline'     => 'Digital studio: web, design, marketing',
		'meta.description' => 'A digital studio building fast, clear, results-driven websites.',

		'nav.about'     => 'About',
		'nav.services'  => 'Services',
		'nav.work'      => 'Work',
		'nav.contact'   => 'Contact',
		'nav.cta'       => 'Get in touch',
		'nav.lang'      => 'RO',
		'nav.lang_aria' => 'Schimbă în română',
		'nav.skip'      => 'Skip to content',
		'nav.menu'      => 'Menu',
		'nav.close'     => 'Close',

		'hero.title_html' => 'Studio<br>Name',
		'hero.quote'      => '“Design is the silent ambassador of your brand.”',
		'hero.quote_by'   => 'Paul Rand',
		'hero.lead'       => 'One sentence that says what you do and for whom, without jargon.',
		'hero.cta'        => 'See our work',
		'hero.cta2'       => 'Discuss a project',

		'about.title'   => 'About',
		'about.p1_html' => '<strong>Studio Name</strong> is a <strong>digital studio</strong> specialised in <strong>web development</strong>, <strong>design</strong> and <strong>marketing</strong>.',
		'about.p2_html' => 'We build websites that are <strong>fast</strong> and <strong>easy to use</strong>, and that <strong>deliver results</strong>.',
		'about.p3_html' => 'Every project starts from <strong>the needs of your business</strong>, not from a template.',

		'why.title_html' => 'Why<br>quality<br>matters',
		'why.s1_html'    => 'of users judge a company’s <strong>credibility</strong> by the <strong>design of its website</strong>.',
		'why.s2_html'    => 'of users would not <strong>recommend</strong> a business with a <strong>poorly designed website</strong>.',
		'why.s3_html'    => 'of users say <strong>design</strong> is the <strong>main reason</strong> they <strong>reject</strong> a website.',

		'services.title'    => 'Services',
		'services.g1'       => 'Web & design',
		'services.g2'       => 'Growth & support',
		'services.1.t'      => 'Web development',
		'services.1.d_html' => '<strong>Custom</strong>, <strong>high-performance</strong> websites.',
		'services.2.t'      => 'UX/UI design',
		'services.2.d_html' => '<strong>Intuitive</strong>, <strong>engaging</strong> experiences.',
		'services.3.t'      => 'E-commerce',
		'services.3.d_html' => '<strong>Scalable</strong> online stores.',
		'services.4.t'      => 'Branding',
		'services.4.d_html' => 'A <strong>coherent</strong> visual <strong>identity</strong>.',
		'services.5.t'      => 'SEO & marketing',
		'services.5.d_html' => '<strong>Visibility</strong> and <strong>traffic</strong> that matter.',
		'services.6.t'      => 'Maintenance',
		'services.6.d_html' => '<strong>Updates</strong>, <strong>security</strong>, <strong>performance</strong>.',

		'vision.1.t'      => 'Vision',
		'vision.1.d_html' => 'A short paragraph about <strong>where you are heading</strong> and the <strong>impact</strong> you want to have.',
		'vision.2.t'      => 'Mission',
		'vision.2.d_html' => 'A short paragraph about <strong>how</strong> you work and <strong>what</strong> you promise every client.',
		'vision.3.t'      => 'Support',
		'vision.3.d_html' => 'A short paragraph about <strong>what happens after launch</strong>: support, optimisation, updates.',

		'work.title' => 'Work',
		'work.lead'  => 'A selection of delivered projects.',
		'work.more'  => 'Show all projects',
		'work.alt'   => 'Screenshot of the website',

		'contact.title'    => 'Get in touch',
		'contact.lead'     => 'Tell us about your project and we reply within one working day.',
		'contact.phone'    => 'Phone',
		'contact.email'    => 'Email',
		'form.name'        => 'Name',
		'form.email'       => 'Email',
		'form.message'     => 'Message',
		'form.message_ph'  => 'What should we build together?',
		'form.submit'      => 'Send message',
		'form.sending'     => 'Sending…',
		'form.sent'        => 'Message sent. We will be in touch shortly.',
		'form.error'       => 'The message could not be sent. Try again or email us directly.',
		'form.err_name'    => 'Enter your name.',
		'form.err_email'   => 'Enter a valid email address, like name@example.com.',
		'form.err_message' => 'Enter a message of at least 10 characters.',

		'footer.thanks' => 'Thank you.',
		'footer.rights' => 'All rights reserved.',
	];

	return $s;
}
