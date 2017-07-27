<?php
/**
 * Custom template tags for this theme.
 *
 * @package Graphy
 */

if ( ! function_exists( 'graphy_logo' ) ) :
/**
 * Display logo image.
 */
function graphy_logo() {
	if ( ! get_theme_mod( 'graphy_logo' ) ) {
		return;
	}
	$logo_tag = ( is_front_page() && get_theme_mod( 'graphy_replace_blogname' ) ) ? 'h1' : 'div';
	$logo_alt = ( get_theme_mod( 'graphy_replace_blogname' ) ) ? get_bloginfo( 'name' ) : '';
	$logo_src = esc_url( get_theme_mod( 'graphy_logo' ) );
	if ( get_theme_mod( 'graphy_retina_logo' ) ) :
		list( $logo_width ) = getimagesize( $logo_src );
		$logo_width = round( $logo_width / 2 ); ?>
		<<?php echo esc_attr( $logo_tag ); ?> class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php echo esc_attr( $logo_alt ); ?>" src="<?php echo esc_attr( $logo_src ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" /></a></<?php echo esc_attr( $logo_tag ); ?>>
	<?php else: ?>
		<<?php echo esc_attr( $logo_tag ); ?> class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php echo esc_attr( $logo_alt ); ?>" src="<?php echo esc_attr( $logo_src ); ?>" /></a></<?php echo esc_attr( $logo_tag ); ?>>
	<?php endif;
}
endif;

if ( ! function_exists( 'graphy_site_title' ) ) :
/**
 * Display site title.
 */
function graphy_site_title() {
	if ( get_theme_mod( 'graphy_logo' ) && get_theme_mod( 'graphy_replace_blogname' ) ) {
		return;
	}
	$title_tag = ( is_front_page() ) ? 'h1' : 'div';
	?>
	<<?php echo esc_attr( $title_tag ); ?> class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo esc_attr( $title_tag ); ?>>
	<?php
}
endif;

if ( ! function_exists( 'graphy_featured_post_background' ) ) :
/**
 * Set background of featured posts.
 */
function graphy_featured_post_background( $image_size = 'graphy-post-thumbnail-large' ) {
	$featured_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
	if ( $featured_url ) {
		 echo ' style="background-image:url(\'' . esc_url( $featured_url[0] ) . '\')"';
	}
}
endif;

if ( ! function_exists( 'graphy_category' ) ) :
/**
 * Display categories.
 */
function graphy_category() {
	if ( get_theme_mod( 'graphy_hide_category' ) ) {
		return;
	}
	$categories = get_the_category();
	$i = 0;
	$length = count( $categories );
	if ( get_theme_mod( 'graphy_hide_featured_category' ) ) {
		foreach( $categories as $category ) {
			if ( get_theme_mod( 'graphy_featured_category' ) == $category->term_id ) {
				$length = $length - 1;
				break;
			}
		}
	}
	if ( $length > 0 ) {
		echo '<div class="cat-links">';
		foreach( $categories as $category ) {
			if ( get_theme_mod( 'graphy_hide_featured_category' ) && get_theme_mod( 'graphy_featured_category' ) == $category->term_id ) {
				continue;
			}
			if ( 0 !== $i++ ) {
				echo '<span class="category-sep">/</span>';
			}
			printf( '<a rel="category tag" href="%1$s" class="category category-%2$s">%3$s</a>',
				esc_url( get_category_link( $category->term_id ) ),
				esc_attr( $category->term_id ),
				esc_html( $category->name )
			);
		}
		echo '</div><!-- .cat-links -->';
		echo "\n";
	}
}
endif;

if ( ! function_exists( 'graphy_entry_meta' ) ) :
/**
 * Display post header meta.
 */
function graphy_entry_meta() {
	// Hide for pages on Search.
	if ( 'post' != get_post_type() ) {
		return;
	}
	?>
	<?php if ( ! get_theme_mod( 'graphy_hide_date' ) || ! get_theme_mod( 'graphy_hide_author' ) || ( ! post_password_required() && comments_open() && ! get_theme_mod( 'graphy_hide_comments_number' ) ) ) : ?>
	<div class="entry-meta">
		<?php if ( ! get_theme_mod( 'graphy_hide_date' ) || ! get_theme_mod( 'graphy_hide_author' ) ) : ?>
			<?php esc_html_e( 'Posted', 'graphy-pro' ) ?>
		<?php endif; ?>
		<?php if ( ! get_theme_mod( 'graphy_hide_date' ) ) : ?>
			<span class="posted-on"><?php esc_html_e( 'on', 'graphy-pro' ); ?>
			<?php printf( '<a href="%1$s" rel="bookmark"><time class="entry-date published updated" datetime="%2$s">%3$s</time></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			); ?>
			</span>
		<?php endif; ?>
		<?php if ( ! get_theme_mod( 'graphy_hide_author' ) ) : ?>
			<span class="byline"><?php esc_html_e( 'by', 'graphy-pro' ); ?>
				<span class="author vcard">
					<?php if ( get_post_meta(get_the_ID(), 'blog_author', true) ) : ?>
						<?php echo get_post_meta(get_the_ID(), 'blog_author', true); ?>
					<?php else: ?>
						<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( esc_html__( 'View all posts by %s', 'graphy-pro' ), get_the_author() );?>"><span class="author-name"><?php echo get_the_author();?></span></a>
					<?php endif; ?>
				</span>
			</span>
		<?php endif; ?>
		<?php if ( ! post_password_required() && comments_open() && ! get_theme_mod( 'graphy_hide_comments_number' ) ) : ?>
			<?php if ( ! get_theme_mod( 'graphy_hide_author' ) || ! get_theme_mod( 'graphy_hide_date' ) ) : ?>
			<span class="entry-meta-sep"> / </span>
			<?php endif; ?>
			<span class="comments-link">
				<?php comments_popup_link( esc_html__( '0 Comment', 'graphy-pro' ), esc_html__( '1 Comment', 'graphy-pro' ), esc_html__( '% Comments', 'graphy-pro' ) ); ?>
			</span>
		<?php endif; ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>
	<?php
}
endif;

if ( ! function_exists( 'graphy_shorten_text' ) ) :
/**
 * Shorten text.
 */
function graphy_shorten_text( $text, $length ) {
	$text = wp_kses( $text, array() );
	if( mb_strlen( $text ) > $length ) {
		$text = mb_substr( $text ,0 ,$length );
		return $text . '...';
	} else {
		return $text;
	}
}
endif;

if ( ! function_exists( 'graphy_author_profile' ) ) :
/**
 * Display author profile when applicable.
 */
function graphy_author_profile() {
	if ( get_post_format() || get_theme_mod( 'graphy_hide_author_profile' ) || get_post_meta(get_the_ID(), 'blog_author', true) ) {
		return;
	}
	?>
	<div class="author-profile">
		<div class="author-profile-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 90 ); ?>
		</div><!-- .author-profile-avatar -->
		<div class="author-profile-meta">
			<div class="author-profile-name"><strong><?php the_author() ?></strong></div>
			<?php
			$url      = get_the_author_meta( 'url' );
			$social_1 = get_the_author_meta( 'social_1' );
			$social_2 = get_the_author_meta( 'social_2' );
			$social_3 = get_the_author_meta( 'social_3' );
			$social_4 = get_the_author_meta( 'social_4' );
			$social_5 = get_the_author_meta( 'social_5' );
			$social_6 = get_the_author_meta( 'social_6' );
			$social_7 = get_the_author_meta( 'social_7' );
			?>
			<?php if ( $url || $social_1 || $social_2 || $social_3 || $social_4 || $social_5 || $social_6 || $social_7 ): ?>
			<div class="author-profile-link menu">
				<?php if( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"></a><?php endif; ?>
				<?php if( $social_1 ) : ?><a href="<?php echo esc_url( $social_1 ); ?>"></a><?php endif; ?>
				<?php if( $social_2 ) : ?><a href="<?php echo esc_url( $social_2 ); ?>"></a><?php endif; ?>
				<?php if( $social_3 ) : ?><a href="<?php echo esc_url( $social_3 ); ?>"></a><?php endif; ?>
				<?php if( $social_4 ) : ?><a href="<?php echo esc_url( $social_4 ); ?>"></a><?php endif; ?>
				<?php if( $social_5 ) : ?><a href="<?php echo esc_url( $social_5 ); ?>"></a><?php endif; ?>
				<?php if( $social_6 ) : ?><a href="<?php echo esc_url( $social_6 ); ?>"></a><?php endif; ?>
				<?php if( $social_7 ) : ?><a href="<?php echo esc_url( $social_7 ); ?>"></a><?php endif; ?>
			</div><!-- .author-profile-link -->
			<?php endif; ?>
		</div><!-- .author-profile-meta -->
		<div class="author-profile-description">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-profile-description-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( esc_html__( 'View all posts by %s &rarr;', 'graphy-pro' ), get_the_author() ); ?></a>
		</div><!-- .author-profile-description -->
	</div><!-- .author-profile -->
	<?php
}
endif;

if ( ! function_exists( 'graphy_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function graphy_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'graphy-pro' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous"><div class="post-nav-title">' . esc_html__( 'Older post', 'graphy-pro' ) . '</div>%link</div>', esc_html_x( '%title', 'Previous post link', 'graphy-pro' ) );
				next_post_link( '<div class="nav-next"><div class="post-nav-title">' . esc_html__( 'Newer post', 'graphy-pro' ) . '</div>%link</div>', esc_html_x( '%title', 'Next post link', 'graphy-pro' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .post-navigation -->
	<?php
}
endif;

if ( ! function_exists( 'graphy_footer_meta' ) ) :
/**
 * Display post footer meta when applicable.
 *
 * @return void
 */
function graphy_footer_meta() {
	// Hide for pages on Search.
	if ( 'post' != get_post_type() ) {
		return;
	}
	// Don't print empty markup if there's no Categories or Tags.
	$tags_list = get_the_tag_list( '', __( ', ', 'graphy' ) );
	if ( get_theme_mod( 'graphy_hide_category' ) && $tags_list == '' ) {
		return;
	}
	?>
	<footer class="entry-meta entry-footer">
		<?php if ( ! get_theme_mod( 'graphy_hide_category' ) ) : ?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'graphy' ), get_the_category_list( __( ', ', 'graphy' ) ) ); ?>
		</span>
		<?php endif; ?>
		<?php if ( $tags_list != '' ) : ?>
		<span class="tags-links">
			<?php printf( __( 'Tagged %1$s', 'graphy' ), $tags_list ); ?>
		</span>
		<?php endif; // End if $tags_list ?>
	</footer><!-- .entry-meta -->
	<?php
}
endif;
