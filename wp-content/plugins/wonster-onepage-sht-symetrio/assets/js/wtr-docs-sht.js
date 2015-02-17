(function($) {

	"use strict";

	$(document).ready(function(){

		function wtr_my_scroll( hackA )
		{
			var scrollD = $( '.' + hackA ).offset().top;
			 $( 'html,body' ).stop().scrollTop( scrollD - 170 );
		}//end wtr_my_scroll

		var $navi = $( '.wtr_onepage_navi' );

		$navi.addClass( 'wtr-one-page-no-color' );

		$navi.click(function( event ){
			event.stopPropagation();

			$navi.addClass( 'wtr-one-page-no-color' );
			$( this ).removeClass( 'wtr-one-page-no-color' );

			var hackA = $( this ).find( 'a:first' ).attr( 'href' ).split( '#' );
			wtr_my_scroll( hackA[ 1 ] );
		});

		$( '#mp-menu' ).find( '.wtr_onepage_navi' ).removeClass( 'current-menu-item' );

		if( window.location.hash )
		{
			setTimeout(function(){
				var hackA = window.location.hash.substring( 1 );
				$( 'a[href$="#' + hackA + '"]' ).parents( 'li' ).removeClass( 'wtr-one-page-no-color' );
				wtr_my_scroll( hackA );
			}, 800 );
		}
	});
})(jQuery);