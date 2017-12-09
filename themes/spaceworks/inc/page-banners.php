<?php
/**
 * Custom Page Banners post type and implementation
 *
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package Spaceworks
 */


/**
 * Set up the Page Banners custom post type
 *
 * AND setup Page Banners columns in dashboard
 *
 * AND setup Page Banners shortcode
 *
 */
 
// Register Custom Post Type
function register_pagebanners() {

	$labels = array(
		'name'                  => _x( 'Page Banners', 'Post Type General Name', 'swtxt' ),
		'singular_name'         => _x( 'Page Banner', 'Post Type Singular Name', 'swtxt' ),
		'menu_name'             => __( 'Page Banners', 'swtxt' ),
		'name_admin_bar'        => __( 'Page Banner', 'swtxt' ),
		'archives'              => __( 'Page Banners Archives', 'swtxt' ),
		'attributes'            => __( 'Page Banner Attributes', 'swtxt' ),
		'parent_item_colon'     => __( 'Parent Page Banner:', 'swtxt' ),
		'all_items'             => __( 'All Page Banners', 'swtxt' ),
		'add_new_item'          => __( 'Add New Page Banner', 'swtxt' ),
		'add_new'               => __( 'Add New', 'swtxt' ),
		'new_item'              => __( 'New Page Banner', 'swtxt' ),
		'edit_item'             => __( 'Edit Page Banner', 'swtxt' ),
		'update_item'           => __( 'Update Page Banner', 'swtxt' ),
		'view_item'             => __( 'View Page Banner', 'swtxt' ),
		'view_items'            => __( 'View Page Banners', 'swtxt' ),
		'search_items'          => __( 'Search Page Banners', 'swtxt' ),
		'not_found'             => __( 'No Page Banners here', 'swtxt' ),
		'not_found_in_trash'    => __( 'No Page Banners found in Trash', 'swtxt' ),
		'featured_image'        => __( 'Featured Image', 'swtxt' ),
		'set_featured_image'    => __( 'Set Featured image', 'swtxt' ),
		'remove_featured_image' => __( 'Remove Featured image', 'swtxt' ),
		'use_featured_image'    => __( 'Use as Featured image', 'swtxt' ),
		'insert_into_item'      => __( 'Insert into Page Banner', 'swtxt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Page Banner', 'swtxt' ),
		'items_list'            => __( 'Page Banners list', 'swtxt' ),
		'items_list_navigation' => __( 'Page Banners list navigation', 'swtxt' ),
		'filter_items_list'     => __( 'Filter Page Banners list', 'swtxt' ),
	);
	$args = array(
		'label'                 => __( 'Page Banners', 'swtxt' ),
		'description'           => __( 'Content for split-banner display boxes within site pages', 'swtxt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => true,
		'capability_type'       => 'page',
		'menu_icon'   => 'dashicons-index-card'
	);
	register_post_type( 'pagebanners', $args );

}
add_action( 'init', 'register_pagebanners', 0 );


// Edit Pagebanners Columns
add_filter( 'manage_edit-pagebanners_columns', 'edit_pagebanners_columns' ) ;

function edit_pagebanners_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Page Banner' ),
		'shortcode' => __( 'Shortcode' ),
		'date' => __( 'Date' )
	);

	return $columns;
}


// Add content to Pagebanners Columns
add_action( 'manage_pagebanners_posts_custom_column', 'manage_pagebanners_columns', 10, 2 );

function manage_pagebanners_columns( $column, $post_id ) {
	global $post;
	$pagebanner_title = $post->post_title;

	switch( $column ) {

		/* If displaying the 'shortcode' column. */
		case 'shortcode' :

			/* Echo the shortcode for this banner */
				echo __( '[banner id="' . $post_id . '" name="' . $pagebanner_title . '"]' );

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}



// Add Page Banner Shortcode
function page_banner_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'id' => null,
			'name' => null
		),
		$atts
	);
	
	$output = '';
	
	if ( $atts['id'] ) {
		
		$post = get_post( $atts['id'] );

	}
	
	if ( $post ) {
	
		$the_content = apply_filters( 'the_content', $post->post_content );
		$the_title = $post->post_title;
		$the_thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'media_hd' );
 		$the_bg_color = get_field('background_color', $post->ID );
		
		$output = '<div class="pagebanner">';
			$output .= '<div class="pagebanner-image" style="background-image: url(' . $the_thumbnail_url . ');"></div>';
			$output .= '<div class="pagebanner-content" style="background-color: ' . $the_bg_color . '; ">';
			$output .= '<h3>' . $the_title . '</h3>';
			$output .= '<div>' . $the_content . '</div>';
			if ( get_field('link_attach_check', $post->ID) ) :
				$output .= '<p class="pagebanner link-attach"><a href="' . get_field('link_attach_url', $post->ID) . '">' . get_field('link_attach_label', $post->ID) . ' &raquo;</a></p>';
			endif;
			$output .= '</div><!-- /pagebanner-content -->';
		$output .= '</div><!-- /pagebanner -->';
	
	}
			
	return $output;

}
add_shortcode( 'banner', 'page_banner_shortcode' );

