<?php
/**
 * The main posts template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spaceworks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			
		<header class="entry-header">
			<h1 class="entry-title">Newsroom</h1>
		</header>
		
		<div id="first-layout">
		<?php 
			$args_first = array(
				'order'					=>	'DESC',
				'orderby'				=>	'date',
			    'posts_per_page' 		=> '2',
			    'ignore_sticky_posts'	=> true
			);
			
			$loop_first = new WP_Query( $args_first );
			
			if( $loop_first->have_posts() ): while( $loop_first->have_posts() ): $loop_first->the_post();
				ajax_post_layout(true);
			endwhile; endif; 
			
			rewind_posts();
		?>
		</div>
		
		<div class="newsletter-signup-cta">
			<?php get_template_part( 'template-parts/newsletter', 'subscribe' ); ?>
		</div><!-- End newsletter-signup-cta -->
		
		<div id="masonry-layout" data-columns>

			<?php if ( have_posts() ) : ?>
	
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
	
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'media' );
	
				endwhile;
	
				// the_posts_navigation();
	
			else :
	
				get_template_part( 'template-parts/content', 'none' );
	
			endif; ?>
		</div><!-- #masonry-layout -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
