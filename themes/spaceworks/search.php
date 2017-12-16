<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Spaceworks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php 
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results: %s', 'spaceworks' ), '<span class="title-contrast">' . get_search_query() . '</span>' );
				?></h1>
			</header><!-- .page-header -->
			
			<div class="newsletter-signup-cta">
				<?php get_template_part( 'template-parts/newsletter', 'subscribe' ); ?>
			</div><!-- End newsletter-signup-cta -->
			
			<div id="masonry-layout" data-columns>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;
			?>

			</div><!-- #masonry-layout -->

			<?php
			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar();
get_footer();
