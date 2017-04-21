<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Graphy
 */

/**
 * Add theme support for Infinite Scroll.
 */
function graphy_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'type'      => 'click',
		'render'    => 'graphy_infinite_scroll_render',
		'footer'    => false,
	) );
}
add_action( 'after_setup_theme', 'graphy_jetpack_setup' );

function graphy_infinite_scroll_render() {
	while ( have_posts() ) : the_post();
		if ( is_archive() || is_search() ) {
			get_template_part( 'content', 'list' );
		} elseif ( '2-column' == get_theme_mod( 'graphy_content' ) || '3-column' == get_theme_mod( 'graphy_content' ) ) {
			get_template_part( 'content', 'grid' );
		} else {
			get_template_part( 'content', get_theme_mod( 'graphy_content' ) );
		}
	endwhile;
}

/**
 * Change headline of Related Posts
 */
function graphy_remove_related_posts() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'graphy_remove_related_posts', 20 );
function graphy_related_posts_headline( $headline ) {
	$headline = sprintf(
				'<h2 class="jp-relatedposts-title">%s</h2>',
				esc_html__( 'You might also like', 'graphy-pro' )
				);
	return $headline;
}
add_filter( 'jetpack_relatedposts_filter_headline', 'graphy_related_posts_headline' );