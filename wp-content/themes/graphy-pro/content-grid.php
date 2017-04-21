<?php
/**
 * @package Graphy
 */

?><div class="post-grid post-grid-list">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() && ! get_theme_mod( 'graphy_hide_featured_image_on_grid' ) ): ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'graphy-post-thumbnail-medium' ); ?></a>
		</div><!-- .post-thumbnail -->
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ): ?>
			<div class="featured"><?php esc_html_e( 'Featured', 'graphy-pro' ); ?></div>
			<?php endif; ?>
			<?php graphy_category(); ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php graphy_entry_meta(); ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<p><?php echo graphy_shorten_text( get_the_excerpt(), 160 ); ?></p>
		</div><!-- .entry-summary -->
	</article><!-- #post-## -->
</div>