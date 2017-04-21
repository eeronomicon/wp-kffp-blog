<?php
/**
 * The template used for displaying single post.
 *
 * @package Graphy
 */
?>

<div class="post-full post-full-summary">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php graphy_category(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php graphy_entry_meta(); ?>
			<?php if ( has_post_thumbnail() && ! get_theme_mod( 'graphy_hide_featured_image_on_full_text' ) ): ?>
			<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'graphy-pro' ), 'after'  => '</div>', 'pagelink' => '<span class="page-numbers">%</span>',  ) ); ?>
		</div><!-- .entry-content -->

		<?php if ( get_the_tags() ) : ?>
		<div class="tags-links">
			<?php the_tags( '', esc_html__( ', ', 'graphy-pro' ) ); ?>
		</div>
		<?php endif; // End if $the_tags ?>

		<?php graphy_author_profile(); ?>

	</article><!-- #post-## -->
    <?php graphy_footer_meta(); ?>
</div><!-- .post-full -->

<?php if ( ! get_theme_mod( 'graphy_hide_post_nav' ) ) : ?>
	<?php graphy_post_nav(); ?>
<?php endif; ?>

<?php if ( class_exists( 'Jetpack_RelatedPosts' ) ) : ?>
	<?php echo do_shortcode( '[jetpack-related-posts]' ); ?>
<?php endif; ?>
