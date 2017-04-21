( function( $ ) {
	"use strict";
	
	// Set Double Tap To Go for Main Navigation.
	var $site_navigation = $( '#site-navigation li:has(ul)' );
	if ( $site_navigation[0] && 783 <= window.innerWidth ) {
		$site_navigation.doubleTapToGo();
	}

	// Set Slick for Featured Posts.
	if( 1 < $( '.slick-item' ).length ) {
		$( '.featured-post' ).slick( {
			arrows: false,
			centerMode: true,
			centerPadding: '10px',
			dots: true,
			mobileFirst: true,
			slidesToShow: 1,
			responsive: [ {
				breakpoint: 783,
				settings: {
					centerMode: true,
					slidesToShow: 1,
					variableWidth: true
				}
			} ]
		} ).click( function( e ) {
			if ( e.pageX < $( window ).width() * ( 1 / 5 ) ) {
				$( this ).slick('slickPrev');
			} else if ( e.pageX > $( window ).width() * ( 4 / 5 ) ) {
				$( this ).slick('slickNext');
			}
		} );
	}

	// Set Sticky Kit for Sticky Sidebar.
	var $sticky_sidebar = $( '#sticky-sidebar' );
	if( ! navigator.userAgent.match( /(iPhone|iPad|Android)/ ) && 0 < $sticky_sidebar.length ) {
		setTimeout( function() {
			$sticky_sidebar.stick_in_parent( {
				offset_top: 24,
				parent: '#content',
			} );
		}, 2000 );
		// Support for Jetpack Infinite Scroll
		$( document.body ).on( 'post-load', function () {
			$( this ).trigger( 'sticky_kit:recalc' );
		} );
	}
} )( jQuery );