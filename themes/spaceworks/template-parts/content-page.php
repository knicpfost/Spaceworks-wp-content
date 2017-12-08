<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spaceworks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
			$page_content_title = get_field('page_content_title');
			
			if ( $page_content_title ) {
				echo '<h1 class="entry-title">' . $page_content_title . '</h1>';
			} else {
				the_title( '<h1 class="entry-title">', '</h1>' ); 
			}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php 
			$featured_buttons = get_field('featured_button_codes');
			if ( $featured_buttons ) : 
		?>
				<div class="featured-buttons">
					<?php echo do_shortcode( $featured_buttons ); ?>
				</div>
		
		<?php 
			endif;
			the_content();
			if ( $featured_buttons ) :
		?>
				<div class="featured-buttons-bottom">
					<?php echo do_shortcode( $featured_buttons ); ?>
				</div>
		<?php
			endif;
		?>
		
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'spaceworks' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
