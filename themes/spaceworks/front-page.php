<?php
/**
 * The main template file
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

get_header(); 

$home_slides_query = new WP_Query( array( 
	'post_type' => 'sw_home_slides',
	'orderby' => 'menu_order',
	'order' => 'ASC'
) );
?>


<?php if ( !wp_is_mobile() ) : ?>

<script type="text/javascript">

jQuery(function($){
	
	var userInteraction = false;
	var start_homeslide_color = $('.homeslide:first-child .homeslide-content').css('background-color');
	var homeslideCount = $( '.homeslide' ).length;
	var i = 1;
	var checkCount = 1;
	var current_homeslide_color = start_homeslide_color;


	var autoAdvanceId = setInterval( function() { advanceHomeslide( i, "auto" ); }, 6000 );

	function advanceHomeslide( hsNum, advType ) {
		
		if ( userInteraction == true ) {
			clearInterval( autoAdvanceId );
		}
		
		console.log( advType );
		
		if ( advType == 'scrolledDown' || advType == 'auto' ) {
			checkCount = homeslideCount - i;
			if ( checkCount > 0 ) {
				i++;
			} else {
				i = 1;
			}
		}
		if ( advType == 'scrolledUp' ) {
			i--;
			if ( i > 0 ) {
				// just continue
			} else {
				i = homeslideCount;
			}
		}
		
		hsNum = i;
		
		
		$('#homeslide-nav-dots a').css('color','#ccc');
		$('.homeslide').fadeOut( 'slow' );
		
		$('#homeslide-nav-dots a[data-dot=' + hsNum + ']').css('color','#000');
		current_homeslide_color = $( '.homeslide:nth-of-type('+ hsNum +') .homeslide-content' ).css('background-color');
		$('.homelogobox .logo').css('background-color', current_homeslide_color);
		$('.homeslide:nth-of-type('+ hsNum +')').fadeIn( 'slow' );
		
		
	
	}
		
	$(document).ready(function() {
		
		$('.homelogobox .logo').css('background-color', start_homeslide_color);
		
		for (var n = 1; n < homeslideCount + 1; n++) {
			
			$('#homeslide-nav-dots').append('<a href="#homeslide-' + n + '" data-dot="' + n + '">&#8226;</a>');
			
		}
		
		$('#homeslide-nav-dots a[data-dot=1]').css('color','#000');
		
		$('#homeslide-nav-dots a').click(function(e) {
			e.preventDefault();
			userInteraction = true;
			
			var slideClicked = $(this).attr('data-dot');
			i = slideClicked;
			
			advanceHomeslide( i, 'clicked' );
			
		});
		
	});
	
	var scrollHandlingHome = {
		    allow: true,
		    reallow: function() {
		        scrollHandlingHome.allow = true;
		    },
		    delay: 1000
	    };
	
	$('html').bind('mousewheel DOMMouseScroll', function (e) {
		userInteraction = true;
		var scrollDelta = (e.originalEvent.wheelDelta || -e.originalEvent.detail);
		
		if (scrollDelta < 0) {
			if ( scrollHandlingHome.allow ) {
				scrollHandlingHome.allow = false;
				setTimeout(scrollHandlingHome.reallow, scrollHandlingHome.delay);
				
				advanceHomeslide( i, 'scrolledDown' );
				
			}
		} else if (scrollDelta > 0) {
			// Scrolled up
			if ( scrollHandlingHome.allow ) {
				scrollHandlingHome.allow = false;
				setTimeout(scrollHandlingHome.reallow, scrollHandlingHome.delay);
				
				advanceHomeslide( i, 'scrolledUp' );
				
			}
		}
	});
	
	
});

</script>
<style type="text/css">
	.homeslide {display: none; }
	.homeslide:first-child {display: block; }
</style>

<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( $home_slides_query->have_posts() ) :
			
			$homeslide_number = 1;
			
			/* Start the Loop */
			while ( $home_slides_query->have_posts() ) : $home_slides_query->the_post();
		?>
		<div class="homeslide homeslide-<?php echo $homeslide_number; $homeslide_number++; ?>">
			<div class="homeslide-image" style="background-image: url(<?php the_post_thumbnail_url( 'media_hd' ); ?>)"></div><!-- .homeslide-image -->
			<div class="homeslide-image-attribution"><h6><?php the_field('homeslide_image_attribution'); ?></h6></div>
			<div class="homeslide-content" style="background-color: <?php the_field('background_color'); ?>">
				<div class="homeslide-content-inner">
					<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
					<?php if ( get_field('link_attach_check') ) : ?>
						<a href="<?php the_field('link_attach_url'); ?>"><?php the_field('link_attach_label'); ?> &raquo;</a>
					<?php endif; ?>
				</div>
			</div><!-- .homeslide-content -->
		</div><!-- .homeslide -->
		<?php
			endwhile;
			wp_reset_postdata();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
		
		</main><!-- #main -->
		<div id="homeslide-nav-dots"></div>
	</div><!-- #primary -->
	
	<div class="newsletter-signup-cta popup">
		<?php get_template_part( 'template-parts/newsletter', 'subscribe' ); ?>
	</div><!-- End newsletter-signup-cta -->
	
<?php get_footer(); ?>
