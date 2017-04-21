<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Graphy
 */
if (   ! is_active_sidebar( 'sidebar' )
	&& ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="secondary" class="sidebar-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<div class="normal-sidebar widget-area">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</div><!-- .normal-sidebar -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div id="sticky-sidebar" class="sticky-sidebar widget-area">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #sticky-sidebar -->
	<?php endif; ?>
</div><!-- #secondary -->
