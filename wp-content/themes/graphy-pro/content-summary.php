<?php
/**
 * @package Graphy
 */
?>

<div class="post-summary post-full-summary">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ): ?>
			<div class="featured"><?php esc_html_e( 'Featured', 'graphy-pro' ); ?></div>
			<?php endif; ?>
			<?php graphy_category(); ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php graphy_entry_meta(); ?>
			<?php if ( has_post_thumbnail() && ! get_theme_mod( 'graphy_hide_featured_image_on_summary' ) ): ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			</div><!-- .post-thumbnail -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<p><a href="<?php the_permalink(); ?>" rel="bookmark" class="continue-reading"><?php esc_html_e( 'Continue reading &rarr;', 'graphy-pro' ); ?></a></p>
		</div><!-- .entry-summary -->
	</article><!-- #post-## -->
</div><!-- .post-summary -->