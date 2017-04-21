<?php
/**
 * The template used for displaying sticky post.
 *
 * @package Graphy
 */
?>

<div class="slick-item">
	<article <?php post_class(); ?><?php graphy_featured_post_background(); ?>>
		<div class="entry-header">
			<div class="featured-table">
				<div class="featured-table-cell">
					<?php graphy_category(); ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo graphy_shorten_text( get_the_title(), 60 ); ?></a></h2>
					<?php if ( ! get_theme_mod( 'graphy_hide_date' ) ) : ?>
					<div class="entry-meta">
						<span class="posted-on">
							<?php printf( '<a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s">%3$s</time></a>',
								esc_url( get_permalink() ),
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() )
							); ?>
						</span>
					</div><!-- .entry-meta -->
					<?php endif; ?>
				</div><!-- .featured-table-cell -->
			</div><!-- .featured-table -->
		</div><!-- .entry-header -->
	</article><!-- #post-## -->
</div>