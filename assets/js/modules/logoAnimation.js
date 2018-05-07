var logoAnimation = (function() {

	var $logo  = $('.site-logo-link, .custom-logo-link'),
		$clone,
		distance,
		initialized = false,

	init = function() {

		if ($logo.length) {

			$clone = $logo.clone().appendTo('.mobile-header-wrapper');

			var cloneOffset 	= $clone.offset(),
				cloneTop 		= cloneOffset.top,
				cloneHeight		= $clone.height(),
				cloneMid 		= cloneTop + cloneHeight / 2,
				$header 		= $('.mobile-header-wrapper'),
				headerOffset 	= $header.offset(),
				headerHeight	= $header.outerHeight(),
				headerMid 		= headerHeight / 2,
				logoOffset		= $logo.offset(),
				logoTop			= logoOffset.top,
				logoWidth 		= $logo.width(),
				logoHeight		= $logo.height(),
				logoMid 		= logoTop + logoHeight / 2;

			distance = logoMid - headerMid;

			$clone.velocity({
				translateY: distance,
				translateX: '-50%'
			}, {
				duration: 0
			});

			initialized = true;
		}
	},

	update = function() {

		if (!$logo.length || !initialized) {
			return;
		}

		if (distance < latestKnownScrollY) {
			$clone.velocity({
				translateY: 0,
				translateX: '-50%'
			}, {
				duration: 0
			});
			return;
		}

		$clone.velocity({
			translateY: distance - latestKnownScrollY,
			translateX: '-50%'
		}, {
			duration: 0
		});
	};

	return {
		init: init,
		update: update
	}

})();