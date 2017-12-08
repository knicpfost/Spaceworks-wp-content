<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spaceworks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		
		<div id="first-layout">
		<?php 
			$current_gallery_post = new WP_Query ( array(
				'category_name'			=>	'current-exhibit-gallery-950',
			    'posts_per_page' 		=>	'1',
			    'fields'				=>	'ids'
			));
			
			$current_gallery_postid = $current_gallery_post->posts[0];
			
			rewind_posts();
			
			$upcoming_gallery_postid = '28952';
			
			$args_first = array(
				'post__in'			=>	array( $current_gallery_postid, $upcoming_gallery_postid ),
				'posts_per_page' 	=>	'2',
				'order'				=>	'ASC',
				'orderby'			=>	'post__in'
			);
			
			$loop_first = new WP_Query( $args_first );
			
			if( $loop_first->have_posts() ): while( $loop_first->have_posts() ): $loop_first->the_post();
				ajax_post_layout(true);
			endwhile; endif; 
			
			rewind_posts();
			query_posts( array(
				'post__not_in'		=>	array( $current_gallery_postid, $upcoming_gallery_postid ),
				'post_type'			=>	'post',
				'post_status'		=>	'publish',
				'category_name'		=>	'gallery-950'
			));  
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

<?php get_sidebar();
	get_footer();




