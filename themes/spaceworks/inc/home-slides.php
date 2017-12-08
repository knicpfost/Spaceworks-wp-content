<?php
/**
 * Custom HomeSlides post type and implementation
 *
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package Spaceworks
 */


/**
 * Set up the HomeSlides custom post type
 *
 */
 
// Register Custom Post Type
function register_home_slides() {

	$labels = array(
		'name'                  => _x( 'HomeSlides', 'Post Type General Name', 'swtxt' ),
		'singular_name'         => _x( 'HomeSlide', 'Post Type Singular Name', 'swtxt' ),
		'menu_name'             => __( 'HomeSlides', 'swtxt' ),
		'name_admin_bar'        => __( 'HomeSlide', 'swtxt' ),
		'archives'              => __( 'HomeSlides Archives', 'swtxt' ),
		'attributes'            => __( 'HomeSlide Attributes', 'swtxt' ),
		'parent_item_colon'     => __( 'Parent HomeSlide:', 'swtxt' ),
		'all_items'             => __( 'All HomeSlides', 'swtxt' ),
		'add_new_item'          => __( 'Add New HomeSlide', 'swtxt' ),
		'add_new'               => __( 'Add New', 'swtxt' ),
		'new_item'              => __( 'New HomeSlide', 'swtxt' ),
		'edit_item'             => __( 'Edit HomeSlide', 'swtxt' ),
		'update_item'           => __( 'Update HomeSlide', 'swtxt' ),
		'view_item'             => __( 'View HomeSlide', 'swtxt' ),
		'view_items'            => __( 'View HomeSlides', 'swtxt' ),
		'search_items'          => __( 'Search HomeSlides', 'swtxt' ),
		'not_found'             => __( 'No HomeSlides here', 'swtxt' ),
		'not_found_in_trash'    => __( 'No HomeSlides found in Trash', 'swtxt' ),
		'featured_image'        => __( 'Banner Image', 'swtxt' ),
		'set_featured_image'    => __( 'Set banner image', 'swtxt' ),
		'remove_featured_image' => __( 'Remove banner image', 'swtxt' ),
		'use_featured_image'    => __( 'Use as banner image', 'swtxt' ),
		'insert_into_item'      => __( 'Insert into HomeSlide', 'swtxt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this HomeSlide', 'swtxt' ),
		'items_list'            => __( 'HomeSlides list', 'swtxt' ),
		'items_list_navigation' => __( 'HomeSlides list navigation', 'swtxt' ),
		'filter_items_list'     => __( 'Filter HomeSlides list', 'swtxt' ),
	);
	$args = array(
		'label'                 => __( 'HomeSlide', 'swtxt' ),
		'description'           => __( 'Large banner slides for Spaceworks homepage', 'swtxt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'taxonomies'            => array(),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 23,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'menu_icon'   => 'dashicons-admin-multisite'
	);
	register_post_type( 'sw_home_slides', $args );

}
add_action( 'init', 'register_home_slides', 0 );