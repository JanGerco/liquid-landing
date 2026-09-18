<?php
/**
 * The landing page.
 */

defined( 'ABSPATH' ) || exit;
get_header();

$blob = static function ( int $n, string $class, string $extra = '' ): string {
	$file = "img/blobs/blob-0{$n}.webp";
	$size = wp_getimagesize( LL_DIR . '/assets/' . $file ) ?: [ 0, 0 ];
	return sprintf(
		'<img class="blob %s" src="%s" width="%d" height="%d" alt="" aria-hidden="true" decoding="async"%s>',
		esc_attr( $class ),
		esc_url( ll_asset( $file ) ),
		$size[0],
		$size[1],
		$extra
	);
};
?>

<section class="hero" aria-labelledby="hero-title">
	<?php echo $blob( 1, 'blob--hero-a', ' fetchpriority="high"' ); ?>
	<?php echo $blob( 2, 'blob--hero-b' ); ?>
	<div class="hero__inner">
		<h1 id="hero-title" class="display display--hero"><?php ll_e( 'hero.title_html' ); ?></h1>
		<figure class="hero__quote">
			<blockquote class="text-body-emphasized"><?php ll_e( 'hero.quote' ); ?></blockquote>
			<figcaption class="text-footnote">— <?php ll_e( 'hero.quote_by' ); ?></figcaption>
		</figure>
		<p class="hero__lead"><?php ll_e( 'hero.lead' ); ?></p>
		<div class="hero__actions">
			<a class="btn btn--filled" href="#work"><?php ll_e( 'hero.cta' ); ?></a>
			<a class="btn btn--plain" href="#contact"><?php ll_e( 'hero.cta2' ); ?></a>
		</div>
	</div>
</section>

<section class="about section" id="about" aria-labelledby="about-title">
	<?php echo $blob( 3, 'blob--about' ); ?>
	<div class="section__inner about__inner">
		<h2 id="about-title" class="display display--section"><?php ll_e( 'about.title' ); ?></h2>
		<div class="prose">
			<p><?php ll_e( 'about.p1_html' ); ?></p>
			<p><?php ll_e( 'about.p2_html' ); ?></p>
			<p><?php ll_e( 'about.p3_html' ); ?></p>
		</div>
	</div>
</section>

<section class="why section" aria-labelledby="why-title">
	<?php echo $blob( 4, 'blob--why' ); ?>
	<div class="section__inner why__inner">
		<h2 id="why-title" class="display display--section"><?php ll_e( 'why.title_html' ); ?></h2>
		<svg width="0" height="0" aria-hidden="true" focusable="false" style="position:absolute"><defs><linearGradient id="ll-ring" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2A10F5"/><stop offset=".6" stop-color="#E23CF0"/><stop offset="1" stop-color="#FF6A63"/></linearGradient></defs></svg>
		<ul class="stats" role="list">
			<?php
			$stats = [ [ 75, 'why.s1_html' ], [ 57, 'why.s2_html' ], [ 94, 'why.s3_html' ] ];
			foreach ( $stats as [ $pct, $key ] ) :
				$circ = 2 * M_PI * 42;
				?>
				<li class="stat">
					<div class="stat__ring" role="img" aria-label="<?php echo esc_attr( $pct ); ?> %">
						<svg viewBox="0 0 100 100" aria-hidden="true">
							<circle class="stat__track" cx="50" cy="50" r="42"/>
							<circle class="stat__value" cx="50" cy="50" r="42" stroke-dasharray="<?php echo esc_attr( round( $circ * $pct / 100, 2 ) . ' ' . round( $circ, 2 ) ); ?>"/>
						</svg>
						<span class="stat__number"><?php echo esc_html( $pct ); ?>%</span>
					</div>
					<p class="stat__text"><?php ll_e( $key ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="services section" id="services" aria-labelledby="services-title">
	<div class="section__inner">
		<h2 id="services-title" class="display display--section"><?php ll_e( 'services.title' ); ?></h2>
		<div class="services__groups">
			<?php
			$groups = [
				[ 'services.g1', [ 1, 2, 3, 4 ] ],
				[ 'services.g2', [ 5, 6 ] ],
			];
			foreach ( $groups as $gi => [ $gkey, $items ] ) :
				?>
				<div class="service-group">
					<h3 class="service-group__title"><span class="service-group__index" aria-hidden="true"><?php echo $gi + 1; ?>.</span> <?php ll_e( $gkey ); ?></h3>
					<ul class="service-list" role="list">
						<?php foreach ( $items as $i ) : ?>
							<li class="service">
								<h4 class="service__title text-headline"><?php ll_e( "services.$i.t" ); ?></h4>
								<p class="service__text"><?php ll_e( "services.$i.d_html" ); ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="vision" aria-label="<?php echo esc_attr( ll_t( 'vision.1.t' ) . ', ' . ll_t( 'vision.2.t' ) . ', ' . ll_t( 'vision.3.t' ) ); ?>" id="vision">
	<div class="vision__track">
		<div class="vision__stage">
			<?php echo $blob( 6, 'blob--vision-a' ); ?>
			<?php echo $blob( 7, 'blob--vision-b' ); ?>
			<div class="section__inner vision__inner">
				<ol class="pillars" role="list">
					<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
						<li class="pillar" data-index="<?php echo $i - 1; ?>"<?php echo $i === 1 ? ' data-active' : ''; ?>>
							<span class="pillar__num" aria-hidden="true">0<?php echo $i; ?></span>
							<div class="pillar__body">
								<h2 class="display display--section"><?php ll_e( "vision.$i.t" ); ?></h2>
								<p class="pillar__text"><?php ll_e( "vision.$i.d_html" ); ?></p>
							</div>
						</li>
					<?php endfor; ?>
				</ol>
				<ol class="vision__steps" aria-hidden="true">
					<li data-active></li><li></li><li></li>
				</ol>
			</div>
		</div>
	</div>
</section>

<?php $portfolio = ll_portfolio(); if ( $portfolio ) : ?>
<section class="work section" id="work" aria-labelledby="work-title">
	<div class="section__inner">
		<div class="work__head">
			<h2 id="work-title" class="display display--section"><?php ll_e( 'work.title' ); ?></h2>
			<p class="work__lead"><?php ll_e( 'work.lead' ); ?></p>
		</div>
		<ul class="work-grid" role="list" id="work-grid">
			<?php foreach ( $portfolio as $i => $item ) :
				$hidden = $i >= 12;
				$tablet = $i >= 6 && $i < 12;   // shown from 640 px; phone starts with six
				$src    = ll_asset( 'img/portfolio/' . $item['slug'] . '.jpg' );
				$alt    = ll_t( 'work.alt' ) . ' ' . $item['name'];
				?>
				<li class="work-card<?php echo $tablet ? ' work-card--tablet' : ''; ?>" style="--client: <?php echo esc_attr( $item['color'] ); ?>"<?php echo $hidden ? ' hidden data-more' : ''; ?>>
					<?php if ( $item['url'] ) : ?><a class="work-card__link" href="<?php echo esc_url( $item['url'] ); ?>" rel="noopener" target="_blank"><?php endif; ?>
					<figure class="work-card__figure">
						<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="1317" height="875" loading="lazy" decoding="async">
						<figcaption class="work-card__name text-headline"><?php echo esc_html( $item['name'] ); ?></figcaption>
					</figure>
					<?php if ( $item['url'] ) : ?></a><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="work__more">
			<button type="button" class="btn btn--tinted" id="work-more" aria-controls="work-grid" aria-expanded="false"><?php ll_e( 'work.more' ); ?></button>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="contact section" id="contact" aria-labelledby="contact-title">
		<div class="section__inner contact__inner">
		<?php
		$sent  = isset( $_GET['sent'] );
		$error = isset( $_GET['error'] ) ? sanitize_key( $_GET['error'] ) : '';
		$err   = static fn( string $f ) => $error === $f ? ll_t( "form.err_$f" ) : '';
		?>
		<form class="contact-form" id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
			<input type="hidden" name="action" value="ll_contact">
			<?php wp_nonce_field( 'll_contact', '_ll_nonce' ); ?>
			<p class="contact-form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>

			<div class="field">
				<label for="cf-name" class="text-subheadline-emphasized"><?php ll_e( 'form.name' ); ?></label>
				<input id="cf-name" name="name" type="text" autocomplete="name" required maxlength="120" aria-describedby="cf-name-err"<?php echo $err( 'name' ) ? ' aria-invalid="true"' : ''; ?>>
				<p class="field__error text-footnote" id="cf-name-err" data-msg="<?php echo esc_attr( ll_t( 'form.err_name' ) ); ?>"><?php echo esc_html( $err( 'name' ) ); ?></p>
			</div>

			<div class="field">
				<label for="cf-email" class="text-subheadline-emphasized"><?php ll_e( 'form.email' ); ?></label>
				<input id="cf-email" name="email" type="email" inputmode="email" autocomplete="email" placeholder="nume@exemplu.ro" required aria-describedby="cf-email-err"<?php echo $err( 'email' ) ? ' aria-invalid="true"' : ''; ?>>
				<p class="field__error text-footnote" id="cf-email-err" data-msg="<?php echo esc_attr( ll_t( 'form.err_email' ) ); ?>"><?php echo esc_html( $err( 'email' ) ); ?></p>
			</div>

			<div class="field">
				<label for="cf-message" class="text-subheadline-emphasized"><?php ll_e( 'form.message' ); ?></label>
				<textarea id="cf-message" name="message" rows="5" required minlength="10" maxlength="5000" placeholder="<?php echo esc_attr( ll_t( 'form.message_ph' ) ); ?>" aria-describedby="cf-message-err"<?php echo $err( 'message' ) ? ' aria-invalid="true"' : ''; ?>></textarea>
				<p class="field__error text-footnote" id="cf-message-err" data-msg="<?php echo esc_attr( ll_t( 'form.err_message' ) ); ?>"><?php echo esc_html( $err( 'message' ) ); ?></p>
			</div>

			<div class="contact-form__footer">
				<button type="submit" class="btn btn--filled"><span class="btn__label"><?php ll_e( 'form.submit' ); ?></span></button>
				<p class="contact-form__status" role="status" aria-live="polite" data-state="<?php echo $sent ? 'sent' : ( $error === 'send' ? 'error' : '' ); ?>">
					<?php echo $sent ? esc_html( ll_t( 'form.sent' ) ) : ( $error === 'send' ? esc_html( ll_t( 'form.error' ) ) : '' ); ?>
				</p>
			</div>
		</form>

		<div class="contact__intro">
			<h2 id="contact-title" class="display display--section"><?php ll_e( 'contact.title' ); ?></h2>
			<p class="contact__lead"><?php ll_e( 'contact.lead' ); ?></p>
			<dl class="contact__details">
				<div>
					<dt class="text-footnote"><?php ll_e( 'contact.phone' ); ?></dt>
					<dd><a href="tel:+40000000000">+40 000 000 000</a></dd>
				</div>
				<div>
					<dt class="text-footnote"><?php ll_e( 'contact.email' ); ?></dt>
					<dd><a href="mailto:hello@example.com">hello@example.com</a></dd>
				</div>
			</dl>
		</div>

	</div>
</section>

<?php get_footer();
