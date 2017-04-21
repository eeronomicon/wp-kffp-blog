<?php
/**
 * Graphy Theme Customizer
 *
 * @package Graphy
 */

/**
 * Set the Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function graphy_customize_register( $wp_customize ) {

	class Graphy_Read_Me extends WP_Customize_Control {
		public function render_content() {
			?>
			<div class="graphy-read-me">
				<p><?php esc_html_e( 'Thank you for using the Graphy Pro theme.', 'graphy-pro' ); ?></p>
				<h3><?php esc_html_e( 'Documentation', 'graphy-pro' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'For instructions on theme configuration, please see the documentation.', 'graphy-pro' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'http://themegraphy.com/documents/graphy/', 'graphy-pro' ) ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'graphy-pro' ); ?></a></p>
				<h3><?php esc_html_e( 'Support', 'graphy-pro' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'If there is something you don\'t understand even after reading the documentation, please feel free to contact support.', 'graphy-pro' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'http://themegraphy.com/support/', 'graphy-pro' ) ); ?>" target="_blank"><?php esc_html_e( 'Support', 'graphy-pro' ); ?></a></p>
			</div>
			<?php
		}
	}

	// Site Identity
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->add_setting( 'graphy_hide_blogdescription', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_blogdescription', array(
		'label'   => esc_html__( 'Hide Tagline', 'graphy-pro' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	// READ ME
	$wp_customize->add_section( 'graphy_read_me', array(
		'title'    => esc_html__( 'READ ME', 'graphy-pro' ),
		'priority' => 1,
	) );
	$wp_customize->add_setting( 'graphy_read_me_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Read_Me( $wp_customize, 'graphy_read_me_text', array(
		'section'  => 'graphy_read_me',
		'priority' => 1,
	) ) );

	// Fonts
	$wp_customize->add_section( 'graphy_fonts', array(
		'title'    => esc_html__( 'Fonts', 'graphy-pro' ),
		'priority' => 30,
	) );
	$wp_customize->add_setting( 'graphy_headings_font', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_headings_font',
	) );
	$wp_customize->add_control( 'graphy_headings_font', array(
		'label'   => esc_html__( 'Headings Font', 'graphy-pro' ),
		'section' => 'graphy_fonts',
		'type'    => 'select',
		'choices' => array(
			''                     => esc_html__( 'Default', 'graphy-pro' ),
			'Source Serif Pro:600' => 'Source Serif Pro',
			'PT Serif:400'         => 'PT Serif',
			'Gentium Basic:700'    => 'Gentium Basic',
			'Alegreya:700'         => 'Alegreya',
			'Source Sans Pro:600'  => 'Source Sans Pro',
			'PT Sans:400'          => 'PT Sans',
			'Roboto:500'           => 'Roboto',
			'Fira Sans:500'        => 'Fira Sans',
			'Roboto Condensed:400' => 'Roboto Condensed',
			'Playfair Display:400' => 'Playfair Display',
			'Roboto Slab:400'      => 'Roboto Slab',
			'Ubuntu:400'           => 'Ubuntu',
		),
		'priority' => 11,
	) );
	$wp_customize->add_setting( 'graphy_headings_font_size', array(
		'default'           => ( 'ja' == get_bloginfo( 'language' ) ) ? '85' : '100',
		'sanitize_callback' => 'graphy_sanitize_headings_font_size',
	) );
	$wp_customize->add_control( 'graphy_headings_font_size', array(
		'label'    => esc_html__( 'Headings Font Size (%)', 'graphy-pro' ),
		'section'  => 'graphy_fonts',
		'type'     => 'text',
		'priority' => 12,
	));
	$wp_customize->add_setting( 'graphy_body_font', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_body_font',
	) );
	$wp_customize->add_control( 'graphy_body_font', array(
		'label'   => esc_html__( 'Body Font', 'graphy-pro' ),
		'section' => 'graphy_fonts',
		'type'    => 'select',
		'choices' => array(
			''                                      => esc_html__( 'Default', 'graphy-pro' ),
			'Lora:400,400italic,700'                => 'Lora',
			'Source Serif Pro:400,600,700'          => 'Source Serif Pro',
			'PT Serif:400,400italic,700'            => 'PT Serif',
			'Gentium Book Basic:400,400italic,700'  => 'Gentium Book Basic',
			'Source Sans Pro:400,400italic,600,700' => 'Source Sans Pro',
			'PT Sans:400,400italic,700'             => 'PT Sans',
			'Roboto:400,400italic,700'              => 'Roboto',
			'Fira Sans:400,400italic,700'           => 'Fira Sans',
		),
		'priority' => 13,
	) );
	$wp_customize->add_setting( 'graphy_body_font_size', array(
		'default'           => ( 'ja' == get_bloginfo( 'language' ) ) ? '17' : '18',
		'sanitize_callback' => 'graphy_sanitize_body_font_size',
	) );
	$wp_customize->add_control( 'graphy_body_font_size', array(
		'label'    => esc_html__( 'Body Font Size (px)', 'graphy-pro' ),
		'section'  => 'graphy_fonts',
		'type'     => 'text',
		'priority' => 14,
	) );

	// Colors
	$wp_customize->get_section( 'colors' )->priority     = 35;
	$wp_customize->add_setting( 'graphy_link_color' , array(
		'default'   => '#a62425',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_link_color', array(
		'label'    => esc_html__( 'Link Color', 'graphy-pro' ),
		'section'  => 'colors',
		'priority' => 13,
	) ) );
	$wp_customize->add_setting( 'graphy_link_hover_color' , array(
		'default'           => '#b85051',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_link_hover_color', array(
		'label'    => esc_html__( 'Link Hover Color', 'graphy-pro' ),
		'section'  => 'colors',
		'priority' => 14,
	) ) );

	// Title
	$wp_customize->add_section( 'graphy_title', array(
		'title'    => esc_html__( 'Title', 'graphy-pro' ),
		'priority' => 50,
	) );
	$wp_customize->add_setting( 'graphy_title_font', array(
		'default' => '',
		'sanitize_callback' => 'graphy_sanitize_title_font',
	) );
	$wp_customize->add_control( 'graphy_title_font', array(
		'label'   => esc_html__( 'Font', 'graphy-pro' ),
		'section' => 'graphy_title',
		'type'    => 'select',
		'choices' => array(
			''                 => esc_html__( 'Default', 'graphy-pro' ),
			'Source Serif Pro' => 'Source Serif Pro (Normal/Bold)',
			'PT Serif'         => 'PT Serif (Normal/Bold)',
			'Gentium Basic'    => 'Gentium Basic (Normal/Bold)',
			'Alegreya'         => 'Alegreya (Normal/Bold)',
			'Source Sans Pro'  => 'Source Sans Pro',
			'PT Sans'          => 'PT Sans (Normal/Bold)',
			'Roboto'           => 'Roboto',
			'Fira Sans'        => 'Fira Sans',
			'Lato'             => 'Lato',
			'Roboto Condensed' => 'Roboto Condensed',
			'Playfair Display' => 'Playfair Display (Normal/Bold)',
			'Roboto Slab'      => 'Roboto Slab',
			'Ubuntu'           => 'Ubuntu',
			'Kaushan Script'   => 'Kaushan Script (Normal)',
		),
		'priority' => 11,
	) );
	$wp_customize->add_setting( 'graphy_title_font_weight', array(
		'default'           => '400',
		'sanitize_callback' => 'graphy_sanitize_font_weight',
	) );
	$wp_customize->add_control( 'graphy_title_font_weight', array(
		'label'   => esc_html__( 'Font Weight', 'graphy-pro' ),
		'section' => 'graphy_title',
		'type'    => 'select',
		'choices' => array(
			'700' => esc_html__( 'Bold', 'graphy-pro' ),
			'400' => esc_html__( 'Normal', 'graphy-pro' ),
			'300' => esc_html__( 'Light', 'graphy-pro' ),
		),
		'priority' => 12,
	) );
	$wp_customize->add_setting( 'graphy_title_font_size', array(
		'default'           => ( 'ja' == get_bloginfo( 'language' ) ) ? '43' : '54',
		'sanitize_callback' => 'graphy_sanitize_title_font_size',
	) );
	$wp_customize->add_control( 'graphy_title_font_size', array(
		'label'    => esc_html__( 'Font Size (px)', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'type'     => 'text',
		'priority' => 13,
	));
	$wp_customize->add_setting( 'graphy_title_font_color' , array(
		'default'           => '#111111',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_title_font_color', array(
		'label'    => esc_html__( 'Font Color', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'priority' => 14,
	) ) );
	$wp_customize->add_setting( 'graphy_title_letter_spacing', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_title_letter_spacing', array(
		'label'    => esc_html__( 'Letter Spacing (px)', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'type'     => 'text',
		'priority' => 15,
	));
	$wp_customize->add_setting( 'graphy_title_margin_top', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_title_margin_top', array(
		'label'    => esc_html__( 'Margin Top (px)', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'type'     => 'text',
		'priority' => 16,
	));
	$wp_customize->add_setting( 'graphy_title_margin_bottom', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_title_margin_bottom', array(
		'label'    => esc_html__( 'Margin Bottom (px)', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'type'     => 'text',
		'priority' => 17,
	));
	$wp_customize->add_setting( 'graphy_title_uppercase', array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_title_uppercase', array(
		'label'    => esc_html__( 'All Uppercase', 'graphy-pro' ),
		'section'  => 'graphy_title',
		'type'     => 'checkbox',
		'priority' => 18,
	) );

	// Logo
	$wp_customize->add_section( 'graphy_logo', array(
		'title'       => esc_html__( 'Logo', 'graphy-pro' ),
		'description' => esc_html__( 'In order to use a retina logo image, you must have a version of your logo that is doubled in size.', 'graphy-pro' ),
		'priority'    => 55,
	) );
	$wp_customize->add_setting( 'graphy_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'graphy_logo', array(
		'label'    => esc_html__( 'Upload Logo', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'priority' => 11,
	) ) );
	$wp_customize->add_setting( 'graphy_replace_blogname', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_replace_blogname', array(
		'label'    => esc_html__( 'Replace Title', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 12,
	) );
	$wp_customize->add_setting( 'graphy_retina_logo', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_retina_logo', array(
		'label'    => esc_html__( 'Retina Ready', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 13,
	) );
	$wp_customize->add_setting( 'graphy_add_border_radius', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_add_border_radius', array(
		'label'    => esc_html__( 'Add Border Radius', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 14,
	) );
	$wp_customize->add_setting( 'graphy_top_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_top_margin', array(
		'label'    => esc_html__( 'Margin Top (px)', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'type'     => 'text',
		'priority' => 15,
	));
	$wp_customize->add_setting( 'graphy_bottom_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_bottom_margin', array(
		'label'    => esc_html__( 'Margin Bottom (px)', 'graphy-pro' ),
		'section'  => 'graphy_logo',
		'type'     => 'text',
		'priority' => 16,
	));

	// Header Image
	$wp_customize->add_setting( 'graphy_header_display', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_header_display'
	) );
	$wp_customize->add_control( 'graphy_header_display', array(
		'label'   => esc_html__( 'Header Image Display', 'graphy-pro' ),
		'section' => 'header_image',
		'type'    => 'radio',
		'choices' => array(
			''         => esc_html__( 'Display on the blog posts index page', 'graphy-pro' ),
			'page'     => esc_html__( 'Display on all static pages', 'graphy-pro' ),
			'site'     => esc_html__( 'Display on the whole site', 'graphy-pro' ),
		),
		'priority' => 20,
	) );

	// Featured Posts
	$wp_customize->add_section( 'graphy_featured', array(
		'title'       => esc_html__( 'Featured Posts', 'graphy-pro' ),
		'priority'    => 75,
	) );
	$wp_customize->add_setting( 'graphy_enable_featured_slider', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_enable_featured_slider', array(
		'label'    => esc_html__( 'Enable Featured Slider', 'graphy-pro' ),
		'section'  => 'graphy_featured',
		'type'     => 'checkbox',
		'priority' => 1,
	) );
	$wp_customize->add_setting( 'graphy_featured_category', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_featured_category',
	) );
	$categories = get_categories();
	$categories_list = array();
	foreach( $categories as $category ) {
		$categories_list[$category->term_id] = esc_html( $category->name );
	}
	$wp_customize->add_control( 'graphy_featured_category', array(
		'label'   => esc_html__( 'Featured Category', 'graphy-pro' ),
		'section' => 'graphy_featured',
		'type'    => 'select',
		'choices' => $categories_list,
		'priority' => 2,
	) );
	$wp_customize->add_setting( 'graphy_hide_featured_category', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_featured_category', array(
		'label'       => esc_html__( 'Hide Featured Category', 'graphy-pro' ),
		'description' => esc_html__( 'Check this box if you want hide the featured category from displaying in post meta.', 'graphy-pro' ),
		'section'     => 'graphy_featured',
		'type'        => 'checkbox',
		'priority'    => 3,
	) );
	$wp_customize->add_setting( 'graphy_featured_slider_number', array(
		'default'           => '4',
		'sanitize_callback' => 'graphy_sanitize_featured_slider_number',
	) );
	$wp_customize->add_control( 'graphy_featured_slider_number', array(
		'label'       => esc_html__( 'Number of Posts to Show (1 to 8)', 'graphy-pro' ),
		'section'     => 'graphy_featured',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 8,
			'step' => 1,
		),
		'priority'    => 4,
	) );
	$wp_customize->add_setting( 'graphy_featured_slider_display', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_featured_slider_display'
	) );
	$wp_customize->add_control( 'graphy_featured_slider_display', array(
		'label'   => esc_html__( 'Featured Slider Display', 'graphy-pro' ),
		'section' => 'graphy_featured',
		'type'    => 'radio',
		'choices' => array(
			''          => esc_html__( 'Display on the blog posts index page', 'graphy-pro' ),
			'front'     => esc_html__( 'Display on the static front page', 'graphy-pro' ),
			'site'      => esc_html__( 'Display on the whole site', 'graphy-pro' ),
		),
		'priority' => 20,
	) );

	// Posts
	$wp_customize->add_section( 'graphy_post', array(
		'title'    => esc_html__( 'Post Display', 'graphy-pro' ),
		'priority' => 80,
	) );
	$wp_customize->add_setting( 'graphy_content', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_content'
	) );
	$wp_customize->add_control( 'graphy_content', array(
		'label'   => esc_html__( 'Post Display on Homepage', 'graphy-pro' ),
		'section' => 'graphy_post',
		'type'    => 'select',
		'choices' => array(
			''         => esc_html__( 'Full Text', 'graphy-pro' ),
			'summary'  => esc_html__( 'Summary', 'graphy-pro' ),
			'2-column' => esc_html__( '2 Column Masonry', 'graphy-pro' ),
			'3-column' => esc_html__( '3 Column Masonry', 'graphy-pro' ),
			'list'     => esc_html__( 'List', 'graphy-pro' ),
		),
		'priority' => 12,
	) );
	$wp_customize->add_setting( 'graphy_hide_category', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_category', array(
		'label'    => esc_html__( 'Hide Categories', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 13,
	) );
	$wp_customize->add_setting( 'graphy_hide_date', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_date', array(
		'label'    => esc_html__( 'Hide Date', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 14,
	) );
	$wp_customize->add_setting( 'graphy_hide_author', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_author', array(
		'label'    => esc_html__( 'Hide Author Name', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 15,
	) );
	$wp_customize->add_setting( 'graphy_hide_comments_number', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_comments_number', array(
		'label'    => esc_html__( 'Hide Comments Number', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 16,
	) );
	$wp_customize->add_setting( 'graphy_hide_featured_image_on_full_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_featured_image_on_full_text', array(
		'label'    => esc_html__( 'Hide Featured Image on Full Text', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 17,
	) );
	$wp_customize->add_setting( 'graphy_hide_featured_image_on_summary', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_featured_image_on_summary', array(
		'label'    => esc_html__( 'Hide Featured Image on Summary', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 18,
	) );
	$wp_customize->add_setting( 'graphy_hide_featured_image_on_grid', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_featured_image_on_grid', array(
		'label'    => esc_html__( 'Hide Featured Image on Masonry', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 19,
	) );
	$wp_customize->add_setting( 'graphy_hide_featured_image_on_list', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_featured_image_on_list', array(
		'label'    => esc_html__( 'Hide Featured Image on List', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 20,
	) );
	$wp_customize->add_setting( 'graphy_hide_author_profile', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_author_profile', array(
		'label'    => esc_html__( 'Hide Author Profile', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 21,
	) );
	$wp_customize->add_setting( 'graphy_hide_post_nav', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_post_nav', array(
		'label'    => esc_html__( 'Hide Older/Newer Post Navigation', 'graphy-pro' ),
		'section'  => 'graphy_post',
		'type'     => 'checkbox',
		'priority' => 22,
	) );

	// Category Colors
	$wp_customize->add_section( 'graphy_category_colors', array(
		'title'       => esc_html__( 'Category Colors', 'graphy-pro' ),
		'description' => esc_html__( 'If you set #ffffff, default color is used', 'graphy-pro' ),
		'priority'    => 85,
	) );
	$wp_customize->add_setting( 'graphy_category_color_default', array(
		'default'           => '#ba9e30',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_category_color_default', array(
		'label'    => esc_html__( 'Default Color', 'graphy-pro' ),
		'section'  => 'graphy_category_colors',
	) ) );
	foreach( $categories as $category ) {
		$wp_customize->add_setting( 'graphy_category_color_' . $category->term_id, array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_category_color_' . $category->term_id, array(
			'label'    => esc_html( $category->name ),
			'section'  => 'graphy_category_colors',
		) ) );
	}

	// Footer
	$wp_customize->add_section( 'graphy_footer', array(
		'title'       => esc_html__( 'Footer', 'graphy-pro' ),
		'description' => esc_html__( 'HTML tags are allowed in the footer text.', 'graphy-pro' ),
		'priority'    => 90,
	) );
	$wp_customize->add_setting( 'graphy_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'graphy_footer_text', array(
		'label'    => esc_html__( 'Footer Text', 'graphy-pro' ),
		'section'  => 'graphy_footer',
		'type'     => 'textarea',
		'priority' => 11,
	) );
	$wp_customize->add_setting( 'graphy_hide_credit', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_credit', array(
		'label'    => esc_html__( 'Hide Credit', 'graphy-pro' ),
		'section'  => 'graphy_footer',
		'type'     => 'checkbox',
		'priority' => 12,
	) );

	// Custom CSS
	$wp_customize->add_section( 'graphy_custom_css', array(
		'title'       => esc_html__( 'Custom CSS', 'graphy-pro' ),
		'description' => esc_html__( 'Set custom Google fonts like this: Open+Sans:300,300italic|Roboto:100,900', 'graphy-pro' ),
		'priority'    => 95,
	) );
	$wp_customize->add_setting( 'graphy_custom_css', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_custom_css',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_custom_css', array(
		'label'    => esc_html__( 'Custom CSS', 'graphy-pro' ),
		'section'  => 'graphy_custom_css',
		'type'     => 'textarea',
		'priority' => 11,
	) );
	$wp_customize->add_setting( 'graphy_custom_google_fonts', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'graphy_custom_google_fonts', array(
		'label'    => esc_html__( 'Custom Google Fonts', 'graphy-pro' ),
		'section'  => 'graphy_custom_css',
		'type'     => 'text',
		'priority' => 12,
	));

	// Menus
	$wp_customize->add_setting( 'graphy_hide_navigation', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_navigation', array(
		'label'    => esc_html__( 'Hide Main Navigation', 'graphy-pro' ),
		'section'  => 'menu_locations',
		'type'     => 'checkbox',
		'priority' => 1,
	) );
	$wp_customize->add_setting( 'graphy_hide_search', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_search', array(
		'label'    => esc_html__( 'Hide Search on Main Navigation', 'graphy-pro' ),
		'section'  => 'menu_locations',
		'type'     => 'checkbox',
		'priority' => 2,
	) );
}
add_action( 'customize_register', 'graphy_customize_register' );

/**
 * Sanitize user inputs.
 */
function graphy_sanitize_checkbox( $value ) {
	if ( $value == 1 ) {
		return 1;
	} else {
		return '';
	}
}
function graphy_sanitize_margin( $value ) {
	if ( preg_match("/^-?[0-9]+$/", $value) ) {
		return $value;
	} else {
		return '0';
	}
}
function graphy_sanitize_headings_font( $value ) {
	$valid = array(
		'Source Serif Pro:600' => 'Source Serif Pro',
		'PT Serif:400'         => 'PT Serif',
		'Gentium Basic:700'    => 'Gentium Basic',
		'Alegreya:700'         => 'Alegreya',
		'Source Sans Pro:600'  => 'Source Sans Pro',
		'PT Sans:400'          => 'PT Sans',
		'Roboto:500'           => 'Roboto',
		'Fira Sans:500'        => 'Fira Sans',
		'Roboto Condensed:400' => 'Roboto Condensed',
		'Playfair Display:400' => 'Playfair Display',
		'Roboto Slab:400'      => 'Roboto Slab',
		'Ubuntu:400'           => 'Ubuntu',
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_headings_font_size( $value ) {
	if ( preg_match("/^[1-9][0-9]*$/", $value) ) {
		return $value;
	} else {
		return ( 'ja' == get_bloginfo( 'language' ) ) ? '85' : '100';
	}
}
function graphy_sanitize_body_font( $value ) {
	$valid = array(
		'Lora:400,400italic,700'                => 'Lora',
		'Source Serif Pro:400,600,700'          => 'Source Serif Pro',
		'PT Serif:400,400italic,700'            => 'PT Serif',
		'Gentium Book Basic:400,400italic,700'  => 'Gentium Book Basic',
		'Source Sans Pro:400,400italic,600,700' => 'Source Sans Pro',
		'PT Sans:400,400italic,700'             => 'PT Sans',
		'Roboto:400,400italic,700'              => 'Roboto',
		'Fira Sans:400,400italic,700'           => 'Fira Sans',
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_body_font_size( $value ) {
	if ( preg_match("/^[1-9][0-9]*$/", $value) ) {
		return $value;
	} else {
		return ( 'ja' == get_bloginfo( 'language' ) ) ? '17' : '18';
	}
}
function graphy_sanitize_title_font( $value ) {
	$valid = array(
		'Source Serif Pro' => 'Source Serif Pro (Normal/Bold)',
		'PT Serif'         => 'PT Serif (Normal/Bold)',
		'Gentium Basic'    => 'Gentium Basic (Normal/Bold)',
		'Alegreya'         => 'Alegreya (Normal/Bold)',
		'Source Sans Pro'  => 'Source Sans Pro',
		'PT Sans'          => 'PT Sans (Normal/Bold)',
		'Roboto'           => 'Roboto',
		'Fira Sans'        => 'Fira Sans',
		'Lato'             => 'Lato',
		'Roboto Condensed' => 'Roboto Condensed',
		'Playfair Display' => 'Playfair Display (Normal/Bold)',
		'Roboto Slab'      => 'Roboto Slab',
		'Ubuntu'           => 'Ubuntu',
		'Kaushan Script'   => 'Kaushan Script (Normal)',
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_font_weight( $value ) {
	$valid = array(
		'700' => esc_html__( 'Bold', 'graphy-pro' ),
		'400' => esc_html__( 'Normal', 'graphy-pro' ),
		'300' => esc_html__( 'Light', 'graphy-pro' ),
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '400';
	}
}
function graphy_sanitize_title_font_size( $value ) {
	if ( preg_match("/^[1-9][0-9]*$/", $value) ) {
		return $value;
	} else {
		return ( 'ja' == get_bloginfo( 'language' ) ) ? '43' : '54';
	}
}
function graphy_sanitize_header_display( $value ) {
	$valid = array(
		''         => esc_html__( 'Display on the blog posts index page', 'graphy-pro' ),
		'page'     => esc_html__( 'Display on all static pages', 'graphy-pro' ),
		'site'     => esc_html__( 'Display on the whole site', 'graphy-pro' ),
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_featured_slider_display( $value ) {
	$valid = array(
		''          => esc_html__( 'Display on the blog posts index page', 'graphy-pro' ),
		'front'     => esc_html__( 'Display on the static front page', 'graphy-pro' ),
		'site'      => esc_html__( 'Display on the whole site', 'graphy-pro' ),
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_content( $value ) {
	$valid = array(
		''         => esc_html__( 'Full Text', 'graphy-pro' ),
		'summary'  => esc_html__( 'Summary', 'graphy-pro' ),
		'2-column' => esc_html__( '2 Column Masonry', 'graphy-pro' ),
		'3-column' => esc_html__( '3 Column Masonry', 'graphy-pro' ),
		'list'     => esc_html__( 'List', 'graphy-pro' ),
	);

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_featured_category( $value ) {
	$categories = get_categories();
	$categories_list = array();
	foreach( $categories as $category ) {
		$categories_list[$category->term_id] = esc_html( $category->name );
	}
	$valid = $categories_list;

	if ( array_key_exists( $value, $valid ) ) {
		return $value;
	} else {
		return '';
	}
}
function graphy_sanitize_featured_slider_number( $value ) {
	if ( preg_match("/^[1-9][0-9]*$/", $value) && 1 <= $value && $value <= 8 ) {
		return $value;
	} else {
		return '4';
	}
}
function graphy_sanitize_custom_css( $value ) {
	$value = wp_kses( $value, array( '\'', '\"' ) );
	$value = str_replace( '&gt;', '>', $value );
	return $value;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function graphy_customize_preview_js() {
	wp_enqueue_script( 'graphy_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160603', true );
}
add_action( 'customize_preview_init', 'graphy_customize_preview_js' );

/**
 * Enqueue Customizer CSS
 */
function graphy_customizer_style() {
	wp_enqueue_style( 'graphy-customizer-style', get_template_directory_uri() . '/css/customizer.css', array() );
}
add_action( 'customize_controls_print_styles', 'graphy_customizer_style');
