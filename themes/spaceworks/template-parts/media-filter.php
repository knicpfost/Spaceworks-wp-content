<?php 
	$current_page = $_SERVER['REQUEST_URI'];
	$filter_options = array(
						'Blog' => '/category/blog-post/',
						'Press' => '/category/press/',
						'Events' => '/category/event/',
						'Videos' => '/tag/video/'
					);
?>
<div class="media-sidebar">
	<form id="media-filters" action="" method="post">
		<select name="nav">
			<?php if ( is_home() ) {
					echo '<option value="/newsroom/">Filter Newsroom</option>';
				} else {
					echo '<option value="/newsroom/">Show All</option>';
				} ?>
			<?php	
				foreach ($filter_options as $key => $value) {
					if ( $current_page != $value ) {
						echo '<option value="' . $value . '">' . $key . '</option>';
					} elseif ( $current_page == $value ) {
						echo '<option value="" selected="selected">' . $key . '</option>';
					}
				}
			?>
		</select>
		<input type="submit" value="Go" id="submit" />
	</form>
	
	<?php if ( is_category('gallery-950') ) : ?>
		<div id="gallerybar" class="gallerybar widget-area" role="complementary">
			<?php dynamic_sidebar( 'gallerybar-1' ); ?>
		</div><!-- #gallerybar -->
	<?php endif; ?>
</div>