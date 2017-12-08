<?php
/**
 * Custom Participants post type and implementation
 *
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package Spaceworks
 */


/**
 * Set up the custom post type 	— Projects
 * 
 * AND the custom taxonomy 		— Projects Categories
 *
 * AND the display shortcode	- [projects]
 *
 */
 
// Register Custom Post Type
function register_projects() {

	$labels = array(
		'name'                  => _x( 'Projects', 'Post Type General Name', 'swtxt' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'swtxt' ),
		'menu_name'             => __( 'Projects', 'swtxt' ),
		'name_admin_bar'        => __( 'Project', 'swtxt' ),
		'archives'              => __( 'Projects Archives', 'swtxt' ),
		'attributes'            => __( 'Project Attributes', 'swtxt' ),
		'parent_item_colon'     => __( 'Parent Project:', 'swtxt' ),
		'all_items'             => __( 'All Projects', 'swtxt' ),
		'add_new_item'          => __( 'Add New Project', 'swtxt' ),
		'add_new'               => __( 'Add New', 'swtxt' ),
		'new_item'              => __( 'New Project', 'swtxt' ),
		'edit_item'             => __( 'Edit Project', 'swtxt' ),
		'update_item'           => __( 'Update Project', 'swtxt' ),
		'view_item'             => __( 'View Project', 'swtxt' ),
		'view_items'            => __( 'View Projects', 'swtxt' ),
		'search_items'          => __( 'Search Projects', 'swtxt' ),
		'not_found'             => __( 'No Projects here', 'swtxt' ),
		'not_found_in_trash'    => __( 'No Projects found in Trash', 'swtxt' ),
		'featured_image'        => __( 'Banner Image', 'swtxt' ),
		'set_featured_image'    => __( 'Set banner image', 'swtxt' ),
		'remove_featured_image' => __( 'Remove banner image', 'swtxt' ),
		'use_featured_image'    => __( 'Use as banner image', 'swtxt' ),
		'insert_into_item'      => __( 'Insert into Project', 'swtxt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Project', 'swtxt' ),
		'items_list'            => __( 'Projects list', 'swtxt' ),
		'items_list_navigation' => __( 'Projects list navigation', 'swtxt' ),
		'filter_items_list'     => __( 'Filter Projects list', 'swtxt' ),
	);
	$args = array(
		'label'                 => __( 'Projects', 'swtxt' ),
		'description'           => __( 'Projects created by clients and alumni of Spaceworks Tacoma', 'swtxt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'taxonomies'            => array( 'project_cat' ),
		'hierarchical'          => true,
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
		'menu_icon'   => 'dashicons-networking'
	);
	register_post_type( 'projects', $args );

}
add_action( 'init', 'register_projects', 0 );




if ( ! function_exists( 'register_projects_taxonomy' ) ) {

// Register Custom Taxonomy
function register_projects_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Project Categories', 'Taxonomy General Name', 'spaceworks' ),
		'singular_name'              => _x( 'Project Category', 'Taxonomy Singular Name', 'spaceworks' ),
		'menu_name'                  => __( 'Project Categories', 'spaceworks' ),
		'all_items'                  => __( 'All Project Categories', 'spaceworks' ),
		'parent_item'                => __( 'Parent Project Category', 'spaceworks' ),
		'parent_item_colon'          => __( 'Parent Project Category:', 'spaceworks' ),
		'new_item_name'              => __( 'New Item Name', 'spaceworks' ),
		'add_new_item'               => __( 'Add New Project Category', 'spaceworks' ),
		'edit_item'                  => __( 'Edit Project Category', 'spaceworks' ),
		'update_item'                => __( 'Update Project Category', 'spaceworks' ),
		'view_item'                  => __( 'View Project Category', 'spaceworks' ),
		'separate_items_with_commas' => __( 'Separate Project Categories with commas', 'spaceworks' ),
		'add_or_remove_items'        => __( 'Add or remove Project Categories', 'spaceworks' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'spaceworks' ),
		'popular_items'              => __( 'Popular Project Categories', 'spaceworks' ),
		'search_items'               => __( 'Search Project Categories', 'spaceworks' ),
		'not_found'                  => __( 'No Project Categories Found', 'spaceworks' ),
		'no_terms'                   => __( 'No Project Categories', 'spaceworks' ),
		'items_list'                 => __( 'Project Categories list', 'spaceworks' ),
		'items_list_navigation'      => __( 'Project Categories list navigation', 'spaceworks' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'project_cat', array( 'projects' ), $args );

}
add_action( 'init', 'register_projects_taxonomy', 0 );

}



// Add Projects Shortcode
function register_projects_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'category' => '',
		),
		$atts
	);
	
	$output = '';
	
	if ( $atts['category'] ) {
		
		$projects_query = new WP_Query( array( 
			'post_type' => 'projects',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'project_cat' => $atts['category']
		) );

	}
	
	if ( $projects_query ) {
	
		if ( $projects_query->have_posts() ) :

		/* Start the Loop */
		while ( $projects_query->have_posts() ) : $projects_query->the_post();
	
			$output .= '<container class="project">';
			
				$output .= '<div class="project-image" style="background-image: url(' . get_the_post_thumbnail_url() . ')"></div>';
				
				$output .= '<div class="project-content">';
					$output .= '<p><strong>' . get_the_title() . '</strong><br/>';
					$output .= get_field('project_client') . '</p>';
					$output .= '<div>' . get_the_content() . '</div>';
					if ( get_field('link_attach_check') ) :
						$output .= '<p class="project-link link-attach"><a href="' . get_field('link_attach_url') . '">' . get_field('link_attach_label') . '</a></p>';
					endif;
				$output .= '</div><!-- .project-content -->';
				
			$output .= '</container><!-- .project -->';

		endwhile;
		wp_reset_postdata();
		endif;
	
	}
			
	return $output;

}
add_shortcode( 'projects', 'register_projects_shortcode' );