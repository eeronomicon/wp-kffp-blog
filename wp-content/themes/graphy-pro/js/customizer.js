/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";
	
	// Site Identity
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Title
	wp.customize( 'graphy_title_letter_spacing', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title' ).css( 'letter-spacing', newval + 'px' );
		} );
	} );
	wp.customize( 'graphy_title_margin_top', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title' ).css( 'margin-top', newval + 'px' );
		} );
	} );
	wp.customize( 'graphy_title_margin_bottom', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title' ).css( 'margin-bottom', newval + 'px' );
		} );
	} );
	wp.customize( 'graphy_title_uppercase', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.site-title' ).css( 'text-transform', 'uppercase' );
			} else {
				$( '.site-title' ).css( 'text-transform', 'none' );
			}
		} );
	} );
	wp.customize( 'graphy_title_font_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title a' ).css( 'color', newval );
		} );
	} );

	// Logo
	wp.customize( 'graphy_logo_margin_top', function( value ) {
		value.bind( function( newval ) {
			$( '.site-logo' ).css( 'margin-top', newval + 'px' );
		} );
	} );
	wp.customize( 'graphy_logo_margin_bottom', function( value ) {
		value.bind( function( newval ) {
			$( '.site-logo' ).css( 'margin-bottom', newval + 'px' );
		} );
	} );

	// Custom CSS
	wp.customize( 'graphy_custom_css', function( value ) {
		value.bind( function( to ) {
			$( '#graphy-custom-css' ).text( to );
		} );
	} );
} )( jQuery );
