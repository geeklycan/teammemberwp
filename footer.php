<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package tmthree
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
        <div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tmthree' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'tmthree' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'tmthree' ), 'tmthree', '<a href="http://syedahmed.me" rel="designer">Syed Ahmed</a>' ); ?>
		</div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
