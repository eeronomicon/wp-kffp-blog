<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Graphy
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Oswald:400,500,700|Roboto+Slab:300,400,700|Roboto:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
<script src="https://use.fontawesome.com/a2b4541f83.js"></script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'graphy-pro' ); ?></a>

	<header id="masthead" class="site-header">

		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/images/freeform-portland.svg" /></a>
			<a class="donate-desktop visible-lg visible-md visible-sm" href="/donor-drive"><i class="fa fa-heart" aria-hidden="true"></i> Donate</a>
		<?php /*graphy_logo();*/ ?>
		<!--<?php graphy_site_title(); ?>
		<?php if ( ! get_theme_mod( 'graphy_hide_blogdescription' ) ) : ?>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
		<?php endif; ?>-->
		<?php if ( has_nav_menu( 'header-social' ) ) : ?>
			<nav id="header-social-link" class="header-social-link social-link">
				<?php wp_nav_menu( array( 'theme_location' => 'header-social', 'depth' => 1, 'link_before'  => '<span class="screen-reader-text">', 'link_after'  => '</span>' ) ); ?>
			</nav><!-- #header-social-link -->
		<?php endif; ?>
		</div><!-- .site-branding -->

		<?php if ( ! get_theme_mod( 'graphy_hide_navigation' ) ) : ?>
		<nav id="site-navigation" class="main-navigation">
			<a href="http://104.236.186.233:8000/stream" target="_new" class="listen-cta"><i class="fa fa-play-circle fa-2x" aria-hidden="true"></i> Listen Now</a>
			<button class="menu-toggle"><span class="menu-text"><?php esc_html_e( 'Menu', 'graphy-pro' ); ?></span></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			<?php if ( ! get_theme_mod( 'graphy_hide_search' ) ) : ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
		</nav><!-- #site-navigation -->
		<?php endif; ?>


		<?php if ( is_page() && has_post_thumbnail() ) : ?>
		<div id="header-image" class="header-image">
			<?php the_post_thumbnail( 'graphy-page-thumbnail' ); ?>
		</div><!-- #header-image -->
		<?php elseif ( ( get_header_image() && 'site' == get_theme_mod( 'graphy_header_display' ) ) ||
		               ( get_header_image() && 'page' == get_theme_mod( 'graphy_header_display' ) && is_page() ) ||
		               ( get_header_image() && 'page' != get_theme_mod( 'graphy_header_display' ) && is_home() ) ) : ?>
		<div id="header-image" class="header-image">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</div><!-- #header-image -->
		<?php endif; ?>

		<?php if ( ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'site' == get_theme_mod( 'graphy_featured_slider_display' ) ) ||
		           ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'front' == get_theme_mod( 'graphy_featured_slider_display' ) && is_front_page() && ! is_home() ) ||
		           ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'front' != get_theme_mod( 'graphy_featured_slider_display' ) && is_home() && ! is_paged() ) ) : ?>
		<div class="featured-post">
			<?php
			$featured = new WP_Query( array(
				'cat'                 => get_theme_mod( 'graphy_featured_category' ),
				'posts_per_page'      => get_theme_mod( 'graphy_featured_slider_number' ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true
			) );
			if ( $featured->have_posts() ) :
				while ( $featured->have_posts() ) : $featured->the_post();
					get_template_part( 'content', 'featured' );
				endwhile;
			endif;
			wp_reset_postdata(); ?>
		</div>
		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
