<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spaceworks
 */

?>

	</div><!-- #content -->
	
	<?php if ( is_front_page() ) : ?>
		<div class="homelogobox">
			<div class="logo"><img src="<?php echo get_stylesheet_directory_uri() . '/images/SW-Logo-home-desktop.png'; ?>" /></div>
			<div class="fullbevel">
				<div class="bevel topleft"></div>
				<div class="bevel topright"></div>
				<div class="mainline topbottom"></div>
				<div class="mainline rightleft"></div>
				<div class="bevel bottomleft"></div>
				<div class="bevel bottomright"></div>
			</div>
		</div>
	<?php endif; ?>
	
</div><!-- #page -->

<?php if ( ! is_front_page() ) : ?>

<footer id="colophon" class="site-footer">

	<div id="footerbar" class="footerbar widget-area" role="complementary">
		<?php dynamic_sidebar( 'footerbar-1' ); ?>
	</div><!-- #footerbar -->
	
</footer><!-- #colophon -->

<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
