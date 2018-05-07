var Sidebar = (function () {

	var $header 		= $('.site-header'),
		$sidebar		= $('#secondary'),
		$siteContent 	= $('.site-content'),

	init = function() {

		if ( !isSingle() || windowWidth < 900 ) {
			return;
		}

		if ( !sidebarFits() ) {
			$body.removeClass('has--fixed-sidebar');
			$sidebar.css('top', 0);

			return;
		}

		$sidebar.css('top', $header.offset().top + parseInt($header.outerHeight(), 10));
		$body.addClass('has--fixed-sidebar');

	},

	isSingle = function() {
		return $body.hasClass('single') || $body.hasClass('page');
	},

	// If site-header + sidebar is greater than window height
	sidebarFits = function() {
		var sidebarHeight =		parseInt($header.outerHeight(), 10) +
								parseInt($sidebar.outerHeight(), 10) +
								parseInt($('.site-footer').outerHeight(), 10) +
								parseInt($siteContent.css('paddingTop'), 10) +
								parseInt($siteContent.css('paddingBottom'), 10) +
								parseInt($html.css('marginTop'), 10) + parseInt($body.css('borderTopWidth'), 10);

		return windowHeight > sidebarHeight;
	};

	return {
		init: init
	}

})();