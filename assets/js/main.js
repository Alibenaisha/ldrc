( function () {
	'use strict';

	// Mobile menu.
	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'primary-nav' );
	if ( toggle && nav ) {
		var setOpen = function ( open ) {
			nav.classList.toggle( 'is-open', open );
			document.body.classList.toggle( 'nav-open', open );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		};
		toggle.addEventListener( 'click', function () {
			setOpen( ! nav.classList.contains( 'is-open' ) );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				setOpen( false );
			}
		} );
		document.addEventListener( 'click', function ( e ) {
			if ( nav.classList.contains( 'is-open' ) && ! nav.contains( e.target ) && ! toggle.contains( e.target ) ) {
				setOpen( false );
			}
		} );
		nav.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( 'a' ) ) {
				setOpen( false );
			}
		} );
	}

	// Header shadow on scroll.
	var header = document.getElementById( 'site-header' );
	if ( header ) {
		var onScroll = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 10 );
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	if ( ! ( 'IntersectionObserver' in window ) || reduced ) {
		return;
	}

	// Reveal on scroll.
	var targets = document.querySelectorAll( '.section-head, .card, .area, .list-item, .partner, .about-media, .about-text, .stat' );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-visible' );
				io.unobserve( entry.target );
			}
		} );
	}, { threshold: 0.12 } );
	targets.forEach( function ( el ) {
		el.classList.add( 'reveal' );
		io.observe( el );
	} );

	// Count-up numbers.
	var counters = document.querySelectorAll( '.stat strong[data-count]' );
	var co = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( ! entry.isIntersecting ) {
				return;
			}
			var el = entry.target;
			var end = parseInt( el.getAttribute( 'data-count' ), 10 ) || 0;
			var start = null;
			var step = function ( ts ) {
				if ( ! start ) {
					start = ts;
				}
				var p = Math.min( ( ts - start ) / 1400, 1 );
				el.textContent = Math.round( end * ( 1 - Math.pow( 1 - p, 3 ) ) );
				if ( p < 1 ) {
					window.requestAnimationFrame( step );
				}
			};
			window.requestAnimationFrame( step );
			co.unobserve( el );
		} );
	}, { threshold: 0.5 } );
	counters.forEach( function ( el ) {
		co.observe( el );
	} );
}() );
