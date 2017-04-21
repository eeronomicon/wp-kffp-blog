<?php
/**
 * The template for the blog posts index page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Graphy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post();
				if ( '2-column' == get_theme_mod( 'graphy_content' ) || '3-column' == get_theme_mod( 'graphy_content' ) ) {
					get_template_part( 'content', 'grid' );
				} else {
					get_template_part( 'content', get_theme_mod( 'graphy_content' ) );
				}
			endwhile; ?>

			<?php
			the_posts_pagination( array(
				'prev_text' => esc_html__( '&laquo; Previous', 'graphy-pro' ),
				'next_text' => esc_html__( 'Next &raquo;', 'graphy-pro' ),
			) );
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( '3-column' !== get_theme_mod( 'graphy_content' ) ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>
