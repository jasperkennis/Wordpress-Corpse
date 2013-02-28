<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */


/*
 * General theme configuration settings
 */

// Add support for post-thumbnails
add_theme_support( 'post-thumbnails' );

// Add support for automatic RSS feed links
add_theme_support( 'automatic-feed-links' );

/*
 * Remove unused items from Admin
 * Add as many items as you like to hide to the $restriced array
 */

function remove_menus () {
global $menu;
	$restricted = array( __('Links') );
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

/** 
 * Cleaner image captions
 */
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

function cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';

	/* Open the caption <div>. */
	$output = '<div' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';

	/* Close the caption </div>. */
	$output .= '</div>';

	/* Return the formatted, clean caption. */
	return $output;
}

/**
 *	Remove nasty p's around img tags
 */

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');

/**
 * Enable custom menu support
 * Customize to your needs
 */

if( function_exists('register_nav_menus') ):
  register_nav_menus( array(
		'main_menu' => 'The main menu',
		'sub_menu' => 'A submenu'
		));
endif;

/*
 * Hide password protected posts everywhere
 */

 // Filter to hide protected posts
function exclude_protected($where) {
	global $wpdb;
	return $where .= " AND {$wpdb->posts}.post_password = '' ";
}

// Decide where to display them
function exclude_protected_action($query) {
	if( !is_single() && !is_page() && !is_admin() ) {
		add_filter( 'posts_where', 'exclude_protected' );
	}
}

// Action to queue the filter at the right time
add_action('pre_get_posts', 'exclude_protected_action');

/**
 * External scripts
 */

function enqueue_theme_scripts() {
  // Unregister standard jQuery and reregister as google code.
  wp_deregister_script('jquery');
  wp_register_script( 'jquery', 'http://code.jquery.com/jquery-latest.min.js', null, '1.8.3', true );
	wp_enqueue_script( 'jquery' );
	
	if( WP_DEBUG ):
		// Plugins
		// For example:
		// wp_enqueue_script( 'infinitescroll', get_template_directory_uri() . '/js/jquery-infinitescroll.min.js', array('jquery'), false, true );
		
		// Classes
		// For example:
		// wp_enqueue_script( 'main-nav', get_template_directory_uri() . '/js/main-nav.js', array('jquery'), false, true );
		
		// Pages, Formats, Elements etc.
		// Scripts for pages, elements etc.
		// wp_enqueue_script( 'application', get_template_directory_uri() . '/js/application.js', array('jquery'), false, true	);
 	else:
		// All concatenated and compressed JS in one file:
		// wp_enqueue_script( 'application', get_template_directory_uri() . '/js/application.min.js', array('jquery'), false, true	);
 	endif;
}

add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

?>
