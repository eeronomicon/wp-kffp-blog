<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Graphy
 */

/**
 * Change the [...] string in the excerpt.
 */
function graphy_change_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'graphy_change_excerpt_more' );

/**
 * Modify the read more link text
 */
function graphy_modify_read_more_link() {
	return '<a class="continue-reading" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html__( 'Continue reading &rarr;', 'graphy-pro' ) . '</a>';
}
add_filter( 'the_content_more_link', 'graphy_modify_read_more_link' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function graphy_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'graphy_page_menu_args' );