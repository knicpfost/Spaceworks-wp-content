<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spaceworks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-item'); ?>>
	<div class="masonry-item-content">
		
		<?php if ( has_post_thumbnail() ) { ?>
			<?php echo '<a href="' . $permalink_url . '" rel="bookmark">'; ?>
				<?php the_post_thumbnail('media_featured'); ?>
			<?php echo '</a>'; ?>
		<?php } ?>
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . $permalink_url . '" rel="bookmark">', '</a></h3>' );
			
			if ( 'post' === get_post_type() ) : ?>			
				<div class="entry-meta">
					<?php spaceworks_media_meta(); ?>
				</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

	</div><!-- .masonry-item-content -->
</article><!-- #post-<?php the_ID(); ?> -->
