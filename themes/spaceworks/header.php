<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spaceworks
 */

if (isset($_POST['nav'])) {
	header("Location: $_POST[nav]");
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,400i,900" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div id="mobile-check"></div>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'spaceworks' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<!-- <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> -->
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<!--    Made by Erik Terwan // 24th of November 2015   -->
			<div id="menuToggle">
				<!-- A fake / hidden checkbox is used as click reciever, so we can use the :checked selector on it. -->
				<input type="checkbox" />
				
				<!-- Some spans to act as a hamburger. They are acting like a real hamburger, not that McDonalds stuff. -->
				<span></span>
				<span></span>
				<span></span>
				
<!-- 				<div id="menuDonate"><a href="/donate/">Donate</a></div> --> 
				
				<div id="menuBacker"></div>
				
				<!-- Too bad the menu has to be inside of the button but hey, it's pure CSS magic. -->
				<div id="menuHolder">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
				?>
					<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						<label>
							<span class="screen-reader-text">Search for:</span>
							<i class="fa fa-search" aria-hidden="true"></i><input type="text" class="search-field" placeholder="Search ..." value="" name="s" title="Search for:" />
						</label>
<!-- 						<input type="submit" class="search-submit" value="Search" /> -->
					</form>
					<div class="partners">
						<p>A joint initiative of</p>
<!-- 						<img src="/wp-content/themes/spaceworks/images/sw_partners.png" /> -->
						<img src="/wp-content/themes/spaceworks/images/tacoma_chamber_logo.jpg" />
						<img src="/wp-content/themes/spaceworks/images/tacoma_city_logo.png" />
					</div>
				</div><!-- #menuHolder -->
			</div><!-- #menuToggle -->
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php if ( ! is_front_page() ) : ?>
	
			<?php 
				$logo_url1 = '/wp-content/themes/spaceworks/images/sw_logo_';
				$logo_url2 = 'tacoma'; // default, will be replaced below
				$logo_url3 = '@1x.png'; // desktop, will be replaced on mobile
				
				if ( get_field('page_logo') ) :
				
					$logo_url2 = get_field('page_logo');
				
				endif;
				
				$logo_url = $logo_url1 . $logo_url2 . $logo_url3;
			?>
			
			<div id="page-logo" style="background-image: url( <?php echo $logo_url; ?> )"></div>
			<div id="page-logo-mobile" style="background-image: url( <?php echo $logo_url1 . $logo_url2 . '_small' . $logo_url3; ?> )"></div>
			
	<?php endif; ?>
	
	<?php if ( is_home() || is_archive() ) :
			get_template_part( 'template-parts/media', 'filter' ); 
		endif; ?>

	<div id="content" class="site-content">
