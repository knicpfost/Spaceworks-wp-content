<?php 

// Add Button Shortcode
function button_shortcode( $atts , $content = null ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'link' => '#',
			'color' => '#1d1d1d'
		),
		$atts
	);
	
	$button = '<a class="button" href="' . $atts['link'] . '" style="background-color: ' . $atts['color'] . '">' . $content . '</a>';
	
	return $button;

}
add_shortcode( 'button', 'button_shortcode' );

// Add Donate Shortcode
function donate_holder_shortcode( $atts , $content = null ) {

	// No Attributes
	$atts = '';
	
	$donate_holder = '<div class="donate-form-holder"></div>';
	
	return $donate_holder;

}
add_shortcode( 'donateform', 'donate_holder_shortcode' );


/* Stop images from being wrapped in P tags */
/*
function filter_ptags_on_images($content){
 return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');
*/


// Remove p tags from images, scripts, and iframes.
function remove_some_ptags( $content ) {
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<script.*>*.<\/script>)\s*<\/p>/iU', '\1', $content);
  $content = preg_replace('/<p>\s*(<iframe.*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
  return $content;
}
add_filter( 'the_content', 'remove_some_ptags' );


/* Remove WordPress Version Number */
function wpb_remove_version() {
	return '';
}
add_filter('the_generator', 'wpb_remove_version');

function wpb_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
	$copyright = "© " . $copyright_dates[0]->firstdate;
	if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
	$copyright .= '-' . $copyright_dates[0]->lastdate;
	}
	$output = $copyright;
	}
	return $output;
}