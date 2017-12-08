<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spaceworks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-layout__panel firsttwo'); ?>>
	<div class="masonry-layout__panel-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>
		<?php } ?>
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
	
			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php spaceworks_media_meta(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

	</div><!-- .masonry-layout__panel-content -->
</article><!-- #post-<?php the_ID(); ?> -->
