<?php
wp_register_script('freeform', get_stylesheet_directory_uri() . '/js/freeform.js', array('jquery'));
wp_enqueue_script('freeform');

/**
 * KFFP - Add Show Custom Post Type
 */

add_action( 'init', 'create_show_post_type' );
function create_show_post_type() {
  register_post_type( 'show',
    array(
      'capabilities' => array(
        'create_posts' => true,
      ),
      'has_archive' => 'old_schedule',
      'labels' => array(
        'name' => __( 'Shows' ),
        'singular_name' => __( 'Show' ),
        'edit_item' => 'Edit Show',
        'new_item' => 'New Show',
        'view_item' => 'View Show',
        'search_items' => 'Search Shows',
        'not_found' => 'No shows found',
        'all_items' => 'All Shows',
      ),
      'map_meta_cap' => true,
      'menu_icon' => 'dashicons-format-audio',
      'public' => true,
      'rewrite' => array(
        'with_front' => false,
      ),
      'supports' => array('title','author','editor','thumbnail','custom-fields'),
    )
  );
}

// ordering for shows archive
add_action( 'pre_get_posts', 'pre_filter_shows_archive' );
function pre_filter_shows_archive( $query ) {
    // only modify front-end category archive pages
    if( is_post_type_archive('show') && !is_admin() && $query->is_main_query() ) {
        $query->set( 'posts_per_page','200' );
        $query->set( 'orderby','meta_value_num' );
        $query->set( 'meta_key','start_day' );

        $query->set( 'meta_query', array(
          'relation' => 'AND',
            array( 'key' => 'start_day', 'compare' => '>=', 'type' => 'numeric' ),
            array( 'key' => 'start_hour', 'compare' => '>=', 'type' => 'numeric' )
          )
        );
        $query->set( 'order','ASC' );
    }
}

add_filter('posts_orderby', 'shows_orderby');
function shows_orderby( $orderby ) {
  if( get_queried_object()->query_var === 'show' )  {

    global $wpdb;
    $orderby = str_replace( $wpdb->prefix.'postmeta.meta_value', 'mt1.meta_value, mt2.meta_value', $orderby );

  }
  return $orderby;
}

// adjust admin UI columns for shows
add_filter('manage_edit-show_columns', 'create_manage_shows_columns');
function create_manage_shows_columns($columns) {
    $columns['dj_name'] = 'DJ';
    $columns['timeslot'] = 'Time Slot';
    $columns['id'] = 'Show ID';

    $stats = $columns['gadwp_stats'];
    if (strlen($stats)) {
      unset($columns['gadwp_stats']);
      $columns['gadwp_stats'] = $stats;
    }

    unset($columns['author']);
    unset($columns['date']);
    unset($columns['wpseo-score']);
    return $columns;
}

add_action('manage_posts_custom_column',  'add_manage_shows_columns');
function add_manage_shows_columns($name) {
    global $post;
    switch ($name) {
        case 'dj_name':
          $output = get_post_meta($post->ID, 'dj_name', true);
          echo $output;

          break;

        case 'id':
          $output = get_post_meta($post->ID, 'id', true);
          echo $output;

          break;

        case 'timeslot':
          echo get_timeslot($post->ID);

          break;
    }
}

// display clean timeslot from custom fields
function display_day_of_week($day, $fancy = false) {
  $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

  $output = $dowMap[$day];

  if (!$fancy) $output = substr($output, 0, 3);

  return $output;
}

function get_timeslot($id, $fancy = false) {
  $output = '';
  $custom_fields = get_post_custom($id);

  $dayInt = $custom_fields['start_day'][0];
  $startHour = $custom_fields['start_hour'][0];
  $endHour = $custom_fields['end_hour'][0];

  if ( strlen($dayInt) ) {
    $output .= display_day_of_week($dayInt, true) . ' ';

    $output .= convert_to_twelve($startHour);
    $output .= '-';
    $output .= convert_to_twelve($endHour);
  }

  return $output;
}

function convert_to_twelve($hour) {
   $output = '';
   
   if ($hour == 0 ) {
        $output = 'Midnight';
    } elseif ($hour < 12) {
        $output = $hour . 'AM';
    } elseif ($hour == 12) {
        $output = 'Noon';
    } else {
        $output = ($hour - 12) . 'PM';
    }
    
    return $output;
}

// Concatenate multiple DJs for show list

function show_all_djs($djs) {
	$output = [];
	foreach($djs as $dj) {
		if ($dj['displayName']) {
			array_push($output, $dj['displayName']);
		}
	}
	return implode(' & ', $output);
}

// redirect logins to Schedule page
/*
function redirect_to_schedule() {
	wp_redirect("http://www.freeformportland.org/schedule");
	exit();
}
add_action('wp_login', 'redirect_to_schedule');
*/

/**
 * KFFP - Clean up admin UI
 */

// hide menus for contributors
add_action( 'admin_menu', 'remove_menus_for_contributors' );
function remove_menus_for_contributors() {
  if (current_user_can('contributor')) {
    remove_menu_page('edit-comments.php');
    remove_menu_page('profile.php');
    remove_menu_page('tools.php');
  }
}

// clean up dashboard
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
  if (current_user_can('contributor')) {
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  }
}

// clean up top admin bar
add_action( 'admin_bar_menu', 'remove_admin_bar_stuff', 999 );
function remove_admin_bar_stuff( $wp_admin_bar ) {
  $wp_admin_bar->remove_node( 'wp-logo' );
  $wp_admin_bar->remove_node( 'wpseo-menu' );
  if ( current_user_can('contributor') ) {
    $wp_admin_bar->remove_node( 'comments' );
  }
}

// setup URL parsing for show slugs
function add_query_vars($aVars) {
	$aVars[] = "show_name";
	return $aVars;
}
add_filter('query_vars', 'add_query_vars');

// Add rewrite rule to shorten show URLs a bit
function custom_rewrite_show_links() {
  add_rewrite_rule('^program/([^/]*)/?', 'index.php?pagename=program&show_name=$matches[1]', 'top');
  add_rewrite_rule('^schedule/?', 'index.php?pagename=programs', 'top');
  add_rewrite_rule('^show/([^/]*)/?', 'index.php?pagename=program&show_name=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_show_links');

/**
 * END KFFP
 */





















/**
 * Graphy functions and definitions
 *
 * @package Graphy
 */

if ( ! function_exists( 'graphy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function graphy_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 700;
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Graphy, use a find and replace
	 * to change 'graphy-pro' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'graphy-pro', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800 );
	add_image_size( 'graphy-post-thumbnail-large', 1080, 600, true );
	add_image_size( 'graphy-post-thumbnail-medium', 482, 300, true );
	add_image_size( 'graphy-post-thumbnail-small', 80, 60, true );
	add_image_size( 'graphy-page-thumbnail', 1260, 350, true );
	update_option( 'large_size_w', 700 );
	update_option( 'large_size_h', 0 );

	// This theme uses wp_nav_menu() in two location.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Main Navigation', 'graphy-pro' ),
		'header-social' => esc_html__( 'Header Social Links', 'graphy-pro' ),
		'footer-social' => esc_html__( 'Footer Social Links', 'graphy-pro' ),
		'footer'        => esc_html__( 'Footer Menu', 'graphy-pro' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// Setup the WordPress core custom header feature.
	add_theme_support( 'custom-header', apply_filters( 'graphy_custom_header_args', array(
		'default-image' => '',
		'width'         => 1260,
		'height'        => 350,
		'flex-height'   => true,
		'header-text'   => false,
	) ) );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/normalize.css', 'style.css', 'css/editor-style.css', str_replace( ',', '%2C', graphy_fonts_url() ) ) );
}
endif; // graphy_setup
add_action( 'after_setup_theme', 'graphy_setup' );

/**
 * Adjust content_width value for full width template.
 */
function graphy_content_width() {
	if ( is_page_template( 'page_fullwidth.php' ) ) {
		global $content_width;
		$content_width = 1080;
	}
}
add_action( 'template_redirect', 'graphy_content_width' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function graphy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'graphy-pro' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'This is the normal sidebar. If you do not use this sidebar or Sticky Sidebar, the page will be a one-column design.', 'graphy-pro' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sticky Sidebar', 'graphy-pro' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Displays while following the PC\'s scrolling.', 'graphy-pro' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'graphy-pro' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'From left to right there are 4 sequential footer widget areas, and the width is auto-adjusted based on how many you use. If you do not use a footer widget, nothing will be displayed.', 'graphy-pro' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'graphy-pro' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'graphy-pro' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'graphy-pro' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Instagram Widget', 'graphy-pro' ),
		'id'            => 'instagram-widget',
		'description'   => esc_html__( 'The Instagram-exclusive widget area.', 'graphy-pro' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'graphy_widgets_init' );

if ( ! function_exists( 'graphy_fonts_url' ) ) :
/**
 * Register Google Fonts.
 *
 * This function is based on code from Twenty Fifteen.
 * https://wordpress.org/themes/twentyfifteen/
 */
function graphy_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Source Serif Pro, translate this to 'off'. Do not translate into your own language.
	 */
	$source_serif_pro = esc_html_x( 'on', 'Source Serif Pro font: on or off', 'graphy-pro' );
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lora, translate this to 'off'. Do not translate into your own language.
	 */
	$lora = esc_html_x( 'on', 'Lora font: on or off', 'graphy-pro' );
	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = esc_html_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'graphy-pro' );

	$title_font    = get_theme_mod( 'graphy_title_font' );
	$headings_font = get_theme_mod( 'graphy_headings_font' );
	$body_font     = get_theme_mod( 'graphy_body_font' );
	$custom_fonts  = get_theme_mod( 'graphy_custom_google_fonts' );

	if ( 'off' !== $source_serif_pro && ! $headings_font ) {
		$fonts[] = 'Source Serif Pro:400';
	}
	if ( 'off' !== $lora && ! $body_font ) {
		$fonts[] = 'Lora:400,400italic,700';
	}
	if ( $title_font ) {
		$title_font_weight = ( get_theme_mod( 'graphy_title_font_weight' ) ) ? get_theme_mod( 'graphy_title_font_weight' ) : '400';
		$fonts[] = graphy_exist_font( $title_font , $title_font_weight );
	}
	if ( $headings_font ) {
		$fonts[] = $headings_font;
	}
	if ( $body_font ) {
		$fonts[] = $body_font;
	}
	if ( $custom_fonts ) {
		$fonts[] = str_replace( '+', ' ', $custom_fonts );
	}

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Return exist Google Font weight.
 */
function graphy_exist_font( $font, $font_weight ) {
	$font_family[] = $font . ":" . $font_weight;
	$font_family[] = $font;
	$google_font_url = 'https://fonts.googleapis.com/css?family=';

	foreach ( $font_family as $value ) {
		$font_family_encoded = urlencode( $value );
		$response = wp_remote_head( $google_font_url . $font_family_encoded );
		if ( '200' == wp_remote_retrieve_response_code( $response ) ) {
			return $value;
			exit;
		}
	}

	return '';
}

/**
 * Enqueue scripts and styles.
 */
function graphy_scripts() {
	wp_enqueue_style( 'graphy-font', esc_url( graphy_fonts_url() ), array(), null );
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css',  array(), '4.1.1' );
	wp_enqueue_style( 'graphy-style', get_stylesheet_uri(), array(), '2.1.1' );
	if ( 'ja' == get_bloginfo( 'language' ) ) {
		wp_enqueue_style( 'graphy-style-ja', get_template_directory_uri() . '/css/ja.css', array(), null );
	}

	wp_enqueue_script( 'graphy-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160525', true );
	if ( ! get_theme_mod( 'graphy_hide_navigation' ) ) {
		wp_enqueue_script( 'graphy-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20160525', true );
		wp_enqueue_script( 'double-tap-to-go', get_template_directory_uri() . '/js/doubletaptogo.min.js', array( 'jquery' ), '1.0.0', true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'site' == get_theme_mod( 'graphy_featured_slider_display' ) ) ||
		 ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'front' == get_theme_mod( 'graphy_featured_slider_display' ) && is_front_page() && ! is_home() ) ||
		 ( get_theme_mod( 'graphy_enable_featured_slider' ) && 'front' != get_theme_mod( 'graphy_featured_slider_display' ) && is_home() && ! is_paged() ) ) {
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.6.0', true );
		wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/css/slick.css', array(), '1.6.0' );
	}
	if ( is_active_sidebar( 'sidebar-2' ) ) {
		wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js', array( 'jquery' ), '1.1.2' );
	}
	wp_enqueue_script( 'graphy-functions', get_template_directory_uri() . '/js/functions.js', array(), '20160822', true );
}
add_action( 'wp_enqueue_scripts', 'graphy_scripts' );

/**
 * Add customizer style to the header.
 */
function graphy_customizer_css() {
	?>
	<style type="text/css">
		/* Fonts */
		<?php if ( $graphy_headings_font_size = get_theme_mod( 'graphy_headings_font_size' ) ) : ?>
		html {
			font-size: <?php echo esc_attr( $graphy_headings_font_size ); ?>%;
		}
		<?php endif; ?>
		body {
			<?php if ( $graphy_body_font = get_theme_mod( 'graphy_body_font' ) ) :
				list( $body_font_family ) = explode( ":", $graphy_body_font );
			?>
			font-family: '<?php echo esc_attr( $body_font_family ); ?>', serif;
			<?php endif; ?>
			<?php if ( $graphy_body_font_size = get_theme_mod( 'graphy_body_font_size' ) ) : ?>
			font-size: <?php echo esc_attr( $graphy_body_font_size ); ?>px;
			<?php endif; ?>
		}
		@media screen and (max-width: 782px) {
			<?php if ( $graphy_headings_font_size ) : ?>
			html {
				font-size: <?php echo esc_attr( $graphy_headings_font_size * 0.9 ); ?>%;
			}
			<?php endif; ?>
			<?php if ( $graphy_body_font_size ) : ?>
			body {
				font-size: <?php echo esc_attr( round( $graphy_body_font_size * 0.94, 1 ) ); ?>px;
			}
			<?php endif; ?>
		}
		<?php if ( $graphy_headings_font = get_theme_mod( 'graphy_headings_font' ) ) :
			list( $headings_font_family, $font_weight ) = explode( ":", $graphy_headings_font );
		?>
			h1, h2, h3, h4, h5, h6, .site-title {
				font-family: '<?php echo esc_attr( $headings_font_family ); ?>', serif;
				font-weight: <?php echo esc_attr( $font_weight ); ?>;
			}
		<?php endif; ?>

		/* Colors */
		<?php if ( $graphy_link_color = get_theme_mod( 'graphy_link_color' ) ) : ?>
		.entry-content a, .entry-summary a, .page-content a, .author-profile-description a, .comment-content a, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a {
			color: <?php echo esc_attr( $graphy_link_color ); ?>;
		}
		<?php endif; ?>
		<?php if ( $graphy_link_hover_color = get_theme_mod( 'graphy_link_hover_color' ) ) : ?>
		.main-navigation a:hover, .entry-content a:hover, .entry-summary a:hover, .page-content a:hover, .author-profile-description a:hover, .comment-content a:hover {
			color: <?php echo esc_attr( $graphy_link_hover_color ); ?>;
		}
		<?php endif; ?>

		<?php if ( ! ( get_theme_mod( 'graphy_logo' ) && get_theme_mod( 'graphy_replace_blogname' ) ) ) :?>
		/* Title */
			.site-title {
				<?php if ( $graphy_title_font = get_theme_mod( 'graphy_title_font' ) ) : ?>
				font-family: '<?php echo esc_attr( $graphy_title_font ); ?>', serif;
				<?php endif; ?>
				<?php if ( $graphy_title_font_weight = get_theme_mod( 'graphy_title_font_weight' ) ) : ?>
				font-weight: <?php echo esc_attr( $graphy_title_font_weight ); ?>;
				<?php endif; ?>
				<?php if ( $graphy_title_font_size = get_theme_mod( 'graphy_title_font_size' ) ) : ?>
				font-size: <?php echo esc_attr( $graphy_title_font_size ); ?>px;
				<?php endif; ?>
				<?php if ( $graphy_title_letter_spacing = get_theme_mod( 'graphy_title_letter_spacing' ) ) : ?>
				letter-spacing: <?php echo esc_attr( $graphy_title_letter_spacing ); ?>px;
				<?php endif; ?>
				<?php if ( $graphy_title_margin_top = get_theme_mod( 'graphy_title_margin_top' ) ) : ?>
				margin-top: <?php echo esc_attr( $graphy_title_margin_top ); ?>px;
				<?php endif; ?>
				<?php if ( $graphy_title_margin_bottom = get_theme_mod( 'graphy_title_margin_bottom' ) ) : ?>
				margin-bottom: <?php echo esc_attr( $graphy_title_margin_bottom ); ?>px;
				<?php endif; ?>
				<?php if ( get_theme_mod( 'graphy_title_uppercase' ) ) : ?>
				text-transform: uppercase;
				<?php endif; ?>
			}
			<?php if ( $graphy_title_font_color = get_theme_mod( 'graphy_title_font_color' ) ) : ?>
			.site-title a, .site-title a:hover {
				color: <?php echo esc_attr( $graphy_title_font_color ); ?>;
			}
			<?php endif; ?>
			<?php if ( $graphy_title_font_size ) : ?>
			@media screen and (max-width: 782px) {
				.site-title {
					font-size: <?php echo esc_attr( $graphy_title_font_size * 0.9 ); ?>px;
				}
			}
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'graphy_logo' ) ) : ?>
		/* Logo */
			.site-logo {
				<?php if ( $graphy_logo_margin_top = get_theme_mod( 'graphy_top_margin' ) ) : ?>
				margin-top: <?php echo esc_attr( $graphy_logo_margin_top ); ?>px;
				<?php endif; ?>
				<?php if ( $graphy_logo_margin_bottom = get_theme_mod( 'graphy_bottom_margin' ) ) : ?>
				margin-bottom: <?php echo esc_attr( $graphy_logo_margin_bottom ); ?>px;
				<?php endif; ?>
			}
			<?php if ( get_theme_mod( 'graphy_add_border_radius' ) ) : ?>
				.site-logo img {
					border-radius: 50%;
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ! get_theme_mod( 'graphy_hide_category' ) ) : ?>
		/* Category Colors */
			<?php if ( $graphy_category_color_default = get_theme_mod( 'graphy_category_color_default' ) ) : ?>
				a.category {
					color: <?php echo esc_attr( $graphy_category_color_default ); ?>;
				}
			<?php endif; ?>
			<?php
			$categories = get_categories();
			foreach( $categories as $category ) {
				$category_color = get_theme_mod( 'graphy_category_color_' . $category->term_id );
				if ( $category_color && '#ffffff' != $category_color ) : ?>
				a.category-<?php echo esc_attr( $category->term_id ); ?> {
					color: <?php echo esc_attr( $category_color ); ?>;
				}
				<?php endif; ?>
			<?php } ?>
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'graphy_customizer_css' );

/**
 * Add custom style to the header.
 */
function graphy_custom_css() {
	?>
	<style type="text/css" id="graphy-custom-css">
		<?php
		echo get_theme_mod( 'graphy_custom_css' );
		?>
	</style>
	<?php
}
add_action( 'wp_head', 'graphy_custom_css' );

/**
 * Add custom classes to the body.
 */
function graphy_body_classes( $classes ) {
	if ( ( is_home() && '3-column' == get_theme_mod( 'graphy_content' ) ) || is_page_template( 'fullwidth.php' ) ) {
		$classes[] = 'full-width';
	} elseif ( ( ! is_active_sidebar( 'sidebar' ) && ! is_active_sidebar( 'sidebar-2' ) ) || is_page_template( 'nosidebar.php' ) || is_404() ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'has-sidebar';
	}

	$footer_widgets = 0;
	$footer_widgets_max = 4;
	for( $i = 1; $i <= $footer_widgets_max; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
				$footer_widgets++;
		}
	}
	$classes[] = 'footer-' . $footer_widgets;

	if ( get_option( 'show_avatars' ) ) {
		$classes[] = 'has-avatars';
	}

	return $classes;
}
add_filter( 'body_class', 'graphy_body_classes' );

/**
 * Add social links on profile
 */
function graphy_modify_user_contact_methods( $user_contact ) {
	$user_contact['social_1'] = esc_html__( 'Social Link 1', 'graphy-pro' );
	$user_contact['social_2'] = esc_html__( 'Social Link 2', 'graphy-pro' );
	$user_contact['social_3'] = esc_html__( 'Social Link 3', 'graphy-pro' );
	$user_contact['social_4'] = esc_html__( 'Social Link 4', 'graphy-pro' );
	$user_contact['social_5'] = esc_html__( 'Social Link 5', 'graphy-pro' );
	$user_contact['social_6'] = esc_html__( 'Social Link 6', 'graphy-pro' );
	$user_contact['social_7'] = esc_html__( 'Social Link 7', 'graphy-pro' );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'graphy_modify_user_contact_methods' );

/**
 * Register the required plugins for this theme.
 */
function graphy_register_required_plugins() {

	/* Array of plugin arrays. */
	$plugins = array(
		array(
			'name'      => 'Jetpack',
			'slug'      => 'jetpack',
			'required'  => false,
		),
		array(
			'name'      => 'WP Instagram Widget',
			'slug'      => 'wp-instagram-widget',
			'required'  => false,
		),
	);

	/* Array of configuration settings. */
	$config = array(
		'id'           => 'graphy-pro',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
		'strings'      => array(
			'nag_type' => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'graphy_register_required_plugins' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Set auto update.
 */
require get_template_directory() . '/inc/theme_update_check.php';
$MyUpdateChecker = new ThemeUpdateChecker(
	'graphy-pro',
	'https://kernl.us/api/v1/theme-updates/575a91a27f0ae5237433606e/'
);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom widgets for this theme.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function add_sitemap_custom_items(){
  $sitemap_custom_items = '<sitemap>
    <loc>http://www.freeformportland.com/kornhub/</loc>
  </sitemap>';

  return $sitemap_custom_items;
}
add_filter( 'wpseo_sitemap_index', 'add_sitemap_custom_items' );
