/* ====== Navigation Logic ====== */

var navigation = (function() {

	var $nav = $('.nav--main'),

	init = function() {
		// initialize the logic behind the main navigation
		// $nav.ariaNavigation();
		mobileNav();
		navigationFocus();
	},

	mobileNav = function () {
		var $nav = $('.main-navigation'),
			$navTrigger = $('.js-nav-trigger'),
			isOpen = false,
			sticked = false;

		/**
		 * bind toggling the navigation drawer to click and touchstart
		 *in order to get rid of the 300ms delay on touch devices we use the touchstart event
		 */
		var triggerEvents = 'click touchstart';

		if (android_ancient) triggerEvents = 'click';

		var $navParent = $nav.parent();

		$navTrigger.on(triggerEvents, function (e) {

			// but we still have to prevent the default behavior of the touchstart event
			// because this way we're making sure the click event won't fire anymore
			e.preventDefault();
			e.stopPropagation();

			isOpen = !isOpen;
			// $('body').toggleClass('nav--is-open');

			var offset;

			navWidth = $nav.outerWidth();

			if ($('body').hasClass('rtl')) {
				offset = -1 * navWidth;
			} else {
				offset = navWidth;
			}

			if(!android_ancient) {

				if (!isOpen) {

					$([$nav, '.mobile-header-wrapper']).each(function (i, obj) {
						$(obj).velocity({
							translateX: 0,
							translateZ: 0.01
						}, {
							duration: 300,
							easing: "easeInQuart",
							complete: function () {
								$nav.appendTo($navParent);
							}
						});
					});

					$html.removeClass('no-scroll');

				} else {

					if ($('#demosite-activate-wrap').length) {
						$nav.css('top', $('.mobile-header').css('top'));
					}

					$([$nav, '.mobile-header-wrapper']).each(function (i, obj) {
						$(obj).velocity({
							translateX: offset,
							translateZ: 0.01
						}, {
							easing: "easeOutCubic",
							duration: 300
						});
					});

					$html.addClass('no-scroll');

				}

				$nav.toggleClass('shadow', isOpen);
			}
		});

	};

	navigationFocus = function () {
		var $menuItemWithChildren = $('.menu-item-has-children');

		$menuItemWithChildren.on('focusin', function(){
			$(this).addClass('is-focused');
		});

		$menuItemWithChildren.on('focusout', function(){
			$(this).removeClass('is-focused');
		});
	};

	return {
		init: init
	}

})();
