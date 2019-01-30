<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'rest_pre_serve_request', function( $value ) {
    header( 'X-Query-Count: '.intval( get_num_queries() ) );
    return $value;
});


/**
 * Adds Support: theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 */
add_action( 'after_setup_theme', function () {
    global $package_prefix;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on VueWP, use a find and replace
	 * to change 'vuewp' to the name of your theme in all the template files.
	 */
//	load_theme_textdomain( 'vuewp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	// add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

});


function register_post_types() {

	$labels = array(
	  'name'=>'Oferta',
	  'singular_name'=>'oferta',
	  'add_new'=>'Dodaj do Oferty',
	  'all_items'=>'Wszystko w Ofercie',
	  'add_new_item'=>'Dodaj',
	  'edit_item'=>'Edytuj',
	  'new_item'=>'Nowa',
	  'view_item'=>'Zobacz',
	  'search_item'=>'Search Portfolio',
	  'not_found'=>'No items found',
	  'not_found_in_trash'=>'No items found in trash',
	  'parent_item_colon'=>'Parent Item'
  );
  
  $args = array(
	  'labels'=>$labels,
	  'public'=>true,
	  'has_archive'=>true,
	  'publicly_queryable'=>true,
	  'query_var'=>true,
	  'rewrite'=>true,
	  'capability_type'=>'post',
	  'hierarchical'=>false,
	  'show_in_rest' => true,
	  'supports'=> array(
		  'title',
		  'editor',
		  'comments',
		  'exerpt',
		  'thumbnail',
		  'revisions'
	  ),
	  'taxonomies'=> array('category'),
	  'menu_position'=>4,
	  'exclude_from_search'=> false
  );
  register_post_type('oferta',$args); 

}

add_action( 'init','register_post_types');


add_filter('theme_templates', 'vsdfvsdvsdvf');

function vsdfvsdvsdvf($templates = array()){
   $templates['kontakt'] = 'kontakt';
   $templates['onas'] = 'onas';
   return $templates;
}