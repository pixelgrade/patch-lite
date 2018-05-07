/* ====== Masonry Logic ====== */

var masonry = (function() {

	var $container 		= $('.grid'),
		$blocks			= $container.children().addClass('post--animated  post--loaded'),
		initialized		= false,
		columns 		= 1,
		deviceOrientation = orientation,

	init = function() {

        // For mobile devices we will not use masonry
		if (windowWidth < 900) {
			evenClasses();
			$container.imagesLoaded(function() {
				showBlocks($blocks);
			});

			$( document.body ).on( 'post-load', function () {
				showBlocks($container.children().addClass('post--animated  post--loaded'));
			} );

			return;
		}

		var isRtl = $body.hasClass('rtl');

		$container.imagesLoaded(function() {
			$container.masonry({
				itemSelector: '.grid__item',
				columnWidth: ".grid__item:not(.site-header)",
				transitionDuration: 0,
				isOriginLeft: !isRtl
			});
			bindEvents();
			onLayout();

			setTimeout(function() {
				$container.masonry('layout');
			}, 100);

			showBlocks($blocks);	
			initialized = true;		
		});
	},

	unbindEvents = function() {
		$body.off('post-load', onLoad);
		$container.masonry('off', 'layoutComplete', onLayout);
	},

	bindEvents = function() {
		$body.on('post-load', onLoad);
		$container.masonry('on', 'layoutComplete', onLayout);
	},

	refresh = function() {

		if (!initialized) {
			init();
			return;
		}

        // For mobile devices we will not use masonry
		if (windowWidth < 900) {
            // Only attempt to destroy if masonry was initialized first
            if ( $container.data('masonry') ) {
                $container.masonry('destroy');
            }

			initialized = false;
			evenClasses();
			return;
		}
		
		$container.masonry('layout');
	},

	evenClasses = function() {
		$container.find('.entry-card--tall, .entry-card--portrait').each(function(i, card) {
			if (i % 2 == 0) {
				$(card).parent().addClass('entry--even');
			} else {
				$(card).parent().removeClass('entry--even');
			}
		});
	},

	showBlocks = function($blocks) {
		$blocks.each(function(i, obj) {
			var $post = $(obj).find('.entry-card, .site-header, .page-header');
			$post.css('transform', 'translateY(0px)');
			animatePost($post, i * 100);
		});
	},

	animatePost = function($post, delay) {
		setTimeout(function() {
			$post.addClass('is-visible');
		}, delay);
	},

	onLayout = function() {

		var values = new Array(),
			newValues = new Array();

		// get left value for each item in the grid
		$container.find('.grid__item').each(function (i, obj) {
			values.push($(obj).offset().left);
		});

		// get unique values representing columns' left offset
		values = values.getUnique(values);

		// keep only the even ones so we can identify what columns need new css classes
		for (var k in values) {
		    if (values.hasOwnProperty(k) && k % 2 == 0) {
		         newValues.push(values[k]);
		    }
		}

		$container.find('.grid__item').each(function (i, obj) {
			var $obj = $(obj),
				left = $obj.offset().left;

			if (!$body.hasClass('rtl')) {
				$obj.css('z-index', values.length - values.indexOf(left));
			} else {
				$obj.css('z-index', values.indexOf(left));
			}

			if ($body.hasClass('rtl')) {
				$obj.toggleClass('entry--even', newValues.indexOf(left) == -1);
			} else {
				$obj.toggleClass('entry--even', newValues.indexOf(left) != -1);
			}

		});

		$container.find('.grid__item:first-child').css('z-index', 40);

		unbindEvents();
		$container.masonry('layout');
		bindEvents();

		setTimeout(function() {
			shadows.init();
		}, 200);
	},

	onLoad = function() {
		var $newBlocks = $container.children().not('.post--loaded').addClass('post--loaded');
		$newBlocks.imagesLoaded(function() {
			$container.masonry('appended', $newBlocks, true).masonry('layout');
			showBlocks($newBlocks);
		});
	};

	return {
		init: init,
		refresh: refresh
	}

})();

/**
 * cardHover jQuery plugin
 *
 * we need to create a jQuery plugin so we can easily create the hover animations on the archive
 * both an window.load and on jetpack's infinite scroll 'post-load'
 */
$.fn.addHoverAnimation = function() {

	return this.each(function(i, obj) {

	    var $obj 			= $(obj),
	    	$otherShadow	= $obj.find('.entry-image-shadow'),
	    	$hisShadow		= $obj.data('shadow'),
	    	$meta			= $obj.find('.entry-meta'),
	    	options 		= {
	    		duration: 300,
	    		easing: 'easeOutQuad',
	    		queue: false
	    	};

	    $obj.off('mouseenter').on('mouseenter', function() {
	    	$obj.velocity({
	    		translateY: 15
	    	}, options);

	    	$otherShadow.velocity({
	    		translateY: -15
	    	}, options);

	    	$meta.velocity({
	    		translateY: '-100%',
	    		opacity: 1
	    	}, options);

		    if (typeof $hisShadow !== "undefined") {
		    	$hisShadow.velocity({
		    		translateY: 15
		    	}, options);
		    }
	    });

	    $obj.off('mouseleave').on('mouseleave', function() {

	    	$obj.velocity({
	    		translateY: 0
	    	}, options);

	    	$otherShadow.velocity({
	    		translateY: 0
	    	}, options);

	    	$meta.velocity({
	    		translateY: 0,
	    		opacity: ''
	    	}, options);

		    if (typeof $hisShadow !== "undefined") {
		    	$hisShadow.velocity({
		    		translateY: 0
		    	}, options);
		    }
	    });

	});

}

Array.prototype.getUnique = function(){
   var u = {}, a = [];
   for(var i = 0, l = this.length; i < l; ++i){
      if(u.hasOwnProperty(this[i])) {
         continue;
      }
      a.push(this[i]);
      u[this[i]] = 1;
   }
   return a;
}