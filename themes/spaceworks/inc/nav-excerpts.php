<?php
/**
 * Add Page excerpts to Wordpress Navigation
 *
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package Spaceworks
 */


add_post_type_support( 'page', 'excerpt' );

function my_nav_menu_item_title( $title, $item, $args, $depth ) {
  $pid = $item->object_id;
  $page_object = get_page( $pid );

  $text = $page_object->post_excerpt;

  $title .= '</a><div class="excerpt">' . $text . '</div><a>';
  return $title;

}
add_filter( 'nav_menu_item_title', 'my_nav_menu_item_title', 10, 4 );