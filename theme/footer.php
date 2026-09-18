</main>

<footer class="site-footer">
	<img class="blob blob--closing" src="<?php echo esc_url( ll_asset( 'img/blobs/blob-09.webp' ) ); ?>" width="1028" height="1000" alt="" aria-hidden="true" decoding="async">
	<div class="site-footer__inner">
		<p class="site-footer__thanks"><?php ll_e( 'footer.thanks' ); ?></p>
		<address class="site-footer__contact">
			<a href="tel:+40000000000">+40 000 000 000</a>
			<a href="mailto:hello@example.com">hello@example.com</a>
		</address>
		<p class="site-footer__legal text-footnote">© <?php echo esc_html( gmdate( 'Y' ) ); ?> Studio Name. <?php ll_e( 'footer.rights' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
