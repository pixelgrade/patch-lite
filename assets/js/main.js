/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work? 
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
(function($) {

    var $event = $.event,
        $special,
        resizeTimeout;

    $special = $event.special.debouncedresize = {
        setup: function() {
            $(this).on("resize", $special.handler);
        },
        teardown: function() {
            $(this).off("resize", $special.handler);
        },
        handler: function(event, execAsap) {
            // Save the context
            var context = this,
                args = arguments,
                dispatch = function() {
                    // set correct event type
                    event.type = "debouncedresize";
                    $event.dispatch.apply(context, args);
                };

            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }

            execAsap ?
                dispatch() :
                resizeTimeout = setTimeout(dispatch, $special.threshold);
        },
        threshold: 150
    };

})(jQuery);
/*global jQuery */
/*!
 * FitText.js 1.2
 *
 * Copyright 2011, Dave Rupert http://daverupert.com
 * Released under the WTFPL license
 * http://sam.zoy.org/wtfpl/
 *
 * Date: Thu May 05 14:23:00 2011 -0600
 */

(function($) {

    $.fn.fitText = function(kompressor, options) {

        // Setup options
        var compressor = kompressor || 1,
            settings = $.extend({
                'minFontSize': Number.NEGATIVE_INFINITY,
                'maxFontSize': Number.POSITIVE_INFINITY
            }, options);

        return this.each(function() {

            // Store the object
            var $this = $(this);

            // Resizer() resizes items based on the object width divided by the compressor * 10
            var resizer = function() {
                $this.css('font-size', Math.max(Math.min($this.width() / (compressor * 10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
            };

            // Call once to set.
            resizer();

            // Call on resize. Opera debounces their resize by default.
            $(window).on('resize.fittext orientationchange.fittext', resizer);

        });

    };

})(jQuery);
/**
 * requestAnimationFrame polyfill by Erik Möller.
 * Fixes from Paul Irish, Tino Zijdel, Andrew Mao, Klemen Slavič, Darius Bacon
 *
 * MIT license
 */
if (!Date.now)
    Date.now = function() {
        return new Date().getTime();
    };

(function() {
    'use strict';

    var vendors = ['webkit', 'moz'];
    for (var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i) {
        var vp = vendors[i];
        window.requestAnimationFrame = window[vp + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = (window[vp + 'CancelAnimationFrame'] || window[vp + 'CancelRequestAnimationFrame']);
    }
    if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
        ||
        !window.requestAnimationFrame || !window.cancelAnimationFrame) {
        var lastTime = 0;
        window.requestAnimationFrame = function(callback) {
            var now = Date.now();
            var nextTime = Math.max(lastTime + 16, now);
            return setTimeout(function() {
                    callback(lastTime = nextTime);
                },
                nextTime - now);
        };
        window.cancelAnimationFrame = clearTimeout;
    }
}());
(function($, undefined) {
    /**
     * Shared variables
     */
    var ua = navigator.userAgent.toLowerCase(),
        platform = navigator.platform.toLowerCase(),
        $window = $(window),
        $document = $(document),
        $html = $('html'),
        $body = $('body'),

        iphone = platform.indexOf("iphone"),
        ipod = platform.indexOf("ipod"),
        android = platform.indexOf("android"),
        android_ancient = (ua.indexOf('mozilla/5.0') !== -1 && ua.indexOf('android') !== -1 && ua.indexOf('applewebKit') !== -1) && ua.indexOf('chrome') === -1,
        apple = ua.match(/(iPad|iPhone|iPod|Macintosh)/i),
        windows_phone = ua.indexOf('windows phone') != -1,
        webkit = ua.indexOf('webkit') != -1,

        firefox = ua.indexOf('gecko') != -1,
        safari = ua.indexOf('safari') != -1 && ua.indexOf('chrome') == -1,

        is_small = $('.js-nav-trigger').is(':visible');

    windowHeight = $window.height(),
        windowWidth = $window.width(),
        documentHeight = $document.height(),
        orientation = windowWidth > windowHeight ? 'portrait' : 'landscape',

        latestKnownScrollY = window.scrollY,
        ticking = false;

    ;
    var logoAnimation = (function() {

        var $logo = $('.site-logo-link, .custom-logo-link'),
            $clone,
            distance,
            initialized = false,

            init = function() {

                if ($logo.length) {

                    $clone = $logo.clone().appendTo('.mobile-header-wrapper');

                    var cloneOffset = $clone.offset(),
                        cloneTop = cloneOffset.top,
                        cloneHeight = $clone.height(),
                        cloneMid = cloneTop + cloneHeight / 2,
                        $header = $('.mobile-header-wrapper'),
                        headerOffset = $header.offset(),
                        headerHeight = $header.outerHeight(),
                        headerMid = headerHeight / 2,
                        logoOffset = $logo.offset(),
                        logoTop = logoOffset.top,
                        logoWidth = $logo.width(),
                        logoHeight = $logo.height(),
                        logoMid = logoTop + logoHeight / 2;

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
    /* --- Magnific Popup Initialization --- */

    function magnificPopupInit() {
        $('.entry-content a[href$=".jpg"], .entry-content a[href$=".jpeg"], .entry-content a[href$=".png"], .entry-content a[href$=".gif"]').filter(function(elem) {
            return !$(this).parents('.gallery, .tiled-gallery').length;
        }).magnificPopup({
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-fade',
            image: {
                markup: '<div class="mfp-figure">' +
                    '<div class="mfp-img"></div>' +
                    '<div class="mfp-bottom-bar">' +
                    '<div class="mfp-title"></div>' +
                    '<div class="mfp-counter"></div>' +
                    '</div>' +
                    '</div>',
                titleSrc: function(item) {
                    var output = '';
                    if (typeof item.el.attr('data-alt') !== "undefined" && item.el.attr('data-alt') !== "") {
                        output += '<small>' + item.el.attr('data-alt') + '</small>';
                    }
                    return output;
                }
            }
        });
    }

    /* ====== Masonry Logic ====== */

    var masonry = (function() {

        var $container = $('.grid'),
            $blocks = $container.children().addClass('post--animated  post--loaded'),
            initialized = false,
            columns = 1,
            deviceOrientation = orientation,

            init = function() {

                // For mobile devices we will not use masonry
                if (windowWidth < 900) {
                    evenClasses();
                    $container.imagesLoaded(function() {
                        showBlocks($blocks);
                    });

                    $(document.body).on('post-load', function() {
                        showBlocks($container.children().addClass('post--animated  post--loaded'));
                    });

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
                    if ($container.data('masonry')) {
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
                $container.find('.grid__item').each(function(i, obj) {
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

                $container.find('.grid__item').each(function(i, obj) {
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

            var $obj = $(obj),
                $otherShadow = $obj.find('.entry-image-shadow'),
                $hisShadow = $obj.data('shadow'),
                $meta = $obj.find('.entry-meta'),
                options = {
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

    Array.prototype.getUnique = function() {
        var u = {},
            a = [];
        for (var i = 0, l = this.length; i < l; ++i) {
            if (u.hasOwnProperty(this[i])) {
                continue;
            }
            a.push(this[i]);
            u[this[i]] = 1;
        }
        return a;
    }
    /* ====== Navigation Logic ====== */

    var navigation = (function() {

        var $nav = $('.nav--main'),

            init = function() {
                // initialize the logic behind the main navigation
                // $nav.ariaNavigation();
                mobileNav();
            },

            mobileNav = function() {
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

                $navTrigger.on(triggerEvents, function(e) {

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

                    if (!android_ancient) {

                        if (!isOpen) {

                            $([$nav, '.mobile-header-wrapper']).each(function(i, obj) {
                                $(obj).velocity({
                                    translateX: 0,
                                    translateZ: 0.01
                                }, {
                                    duration: 300,
                                    easing: "easeInQuart",
                                    complete: function() {
                                        $nav.appendTo($navParent);
                                    }
                                });
                            });

                            $html.removeClass('no-scroll');

                        } else {

                            if ($('#demosite-activate-wrap').length) {
                                $nav.css('top', $('.mobile-header').css('top'));
                            }

                            $([$nav, '.mobile-header-wrapper']).each(function(i, obj) {
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

        return {
            init: init
        }

    })();

    // /* ====== Search Overlay Logic ====== */
    (function() {

        var isOpen = false,
            $overlay = $('.overlay--search');

        // update overlay position (if it's open) on window.resize
        // $window.on('debouncedresize', function() {

        //   windowWidth = $window.outerWidth();

        //   if (isOpen) {
        //     $overlay.velocity({
        //       translateX: -1 * windowWidth
        //     }, {
        //       duration: 200,
        //       easing: "easeInCubic"
        //     });
        //   }

        // });

        /**
         * dismiss overlay
         */
        function closeOverlay() {

            if (!isOpen) {
                return;
            }

            $overlay.removeClass('is-visible');

            // remove focus from the search field
            $overlay.find('input').blur();

            isOpen = false;
        }

        function escOverlay(e) {
            if (e.keyCode == 27) {
                closeOverlay();
            }
        }

        // create animation and run it on
        $('.nav__item--search, [href*="#search"]').on('click touchstart', function(e) {
            // prevent default behavior and stop propagation
            e.preventDefault();
            e.stopPropagation();

            // if through some kind of sorcery the navigation drawer is already open return
            if (isOpen) {
                return;
            }

            var offset;

            if ($body.hasClass('rtl')) {
                offset = windowWidth
            } else {
                offset = -1 * windowWidth
            }

            // automatically focus the search field so the user can type right away
            $overlay.find('input').focus();

            $overlay.addClass('is-visible');

            $('.search-form').velocity({
                translateX: 300,
                opacity: 0
            }, {
                duration: 0
            }).velocity({
                opacity: 1
            }, {
                duration: 200,
                easing: "easeOutQuad",
                delay: 200,
                queue: false
            }).velocity({
                translateX: 0
            }, {
                duration: 400,
                easeing: [0.175, 0.885, 0.320, 1.275],
                delay: 50,
                queue: false
            });

            $('.overlay__wrapper > p').velocity({
                translateX: 200,
                opacity: 0
            }, {
                duration: 0
            }).velocity({
                opacity: 1
            }, {
                duration: 400,
                easing: "easeOutQuad",
                delay: 350,
                queue: false
            }).velocity({
                translateX: 0
            }, {
                duration: 400,
                easing: [0.175, 0.885, 0.320, 1.275],
                delay: 250,
                queue: false
            });

            // bind overlay dismissal to escape key
            $(document).on('keyup', escOverlay);

            isOpen = true;
        });

        // create function to hide the search overlay and bind it to the click event
        $('.overlay__close').on('click touchstart', function(e) {

            e.preventDefault();
            e.stopPropagation();

            closeOverlay();

            // unbind overlay dismissal from escape key
            $(document).off('keyup', escOverlay);

        });

    })();
    var shadows = (function() {

        var images,

            // get all images and info about them and store them
            // in the images array;
            init = function() {

                images = new Array();

                jQuery('.entry-image-shadow').remove();
                jQuery('.entry-card').removeData('shadow');

                $('.entry-card .entry-image img').not('.video-player img').each(function(i, obj) {
                    var image = new Object(),
                        card = new Object(),
                        $obj = $(obj),
                        imageOffset,
                        imageWidth,
                        imageHeight,
                        cardOffset,
                        cardWidth,
                        cardHeight;

                    image.$el = $obj;
                    imageOffset = image.$el.offset();
                    imageWidth = image.$el.outerWidth();
                    imageHeight = image.$el.outerHeight();
                    image.x0 = imageOffset.left;
                    image.y0 = imageOffset.top;
                    image.x1 = image.x0 + imageWidth;
                    image.y1 = image.y0 + imageHeight;
                    image.isPortrait = $obj.closest('.entry-image').hasClass('entry-image--tall') || $obj.closest('.entry-image').hasClass('entry-image--portrait');
                    image.isEven = $obj.closest('.grid__item').hasClass('entry--even');

                    card.$el = $obj.closest('.entry-card');
                    cardOffset = card.$el.offset();
                    cardWidth = card.$el.outerWidth();
                    cardHeight = card.$el.outerHeight();
                    card.x0 = cardOffset.left;
                    card.y0 = cardOffset.top;
                    card.x1 = card.x0 + cardWidth;
                    card.y1 = card.y0 + cardHeight;

                    image.card = card;

                    images.push(image);
                });

                refresh();
            },

            // test for overlaps and do some work
            refresh = function() {

                for (var i = 0; i <= images.length - 1; i++) {
                    for (var j = i + 1; j <= images.length - 1; j++) {

                        var source, destination, left, right;

                        // if we're testing the same image back off
                        if (images[i].$el == images[j].$el) {
                            return;
                        }

                        if (images[i].card.x0 < images[j].card.x0) {
                            left = images[i];
                            right = images[j];
                        } else {
                            left = images[j];
                            right = images[i];
                        }

                        if (right.isEven && left.isPortrait && right.isPortrait && imagesOverlap(left.card, right.card)) {
                            right.$el.closest('.grid__item').removeClass('entry--even');
                            right.isEven = true;
                        }

                        source = !left.isPortrait || left.isEven ? left : left.card;
                        destination = right;


                        if (imagesOverlap(source, destination)) {
                            createShadow(source, destination);
                        }

                    }
                }

                if (!$.support.touch) {
                    $('.entry-card').addHoverAnimation();
                }
            },

            createShadow = function(source, destination) {
                // let's assume image1 is over image2
                // we need to create a div
                var $placeholder = $('<div class="entry-image-shadow">'),
                    $shadows = source.$el.data('shadow'),
                    $card = typeof source.card == "undefined" ? source.$el : source.card.$el;

                $placeholder.css({
                    position: "absolute",
                    top: source.y0 - destination.y0,
                    left: source.x0 - destination.x0,
                    width: source.x1 - source.x0,
                    height: source.y1 - source.y0
                });

                if (typeof $shadows == "undefined") {
                    $shadows = $placeholder;
                } else {
                    $shadows = $shadows.add($placeholder);
                }

                $card.data('shadow', $shadows);
                $placeholder.data('source', source.$el[0]);
                $placeholder.insertAfter(destination.$el);
            },

            imagesOverlap = function(image1, image2) {
                return (image1.x0 < image2.x1 && image1.x1 > image2.x0 && image1.y0 < image2.y1 && image1.y1 > image2.y0);
            };

        return {
            init: init,
            refresh: refresh
        }
    })();
    var Sidebar = (function() {

        var $header = $('.site-header'),
            $sidebar = $('#secondary'),
            $siteContent = $('.site-content'),

            init = function() {

                if (!isSingle() || windowWidth < 900) {
                    return;
                }

                if (!sidebarFits()) {
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
                var sidebarHeight = parseInt($header.outerHeight(), 10) +
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
    // /* ====== ON DOCUMENT READY ====== */

    $(document).ready(function() {
        init();
    });

    function init() {
        browserSize();
        platformDetect();
        masonry.refresh();
        reorderSingleFooter();
    }

    // /* ====== ON WINDOW LOAD ====== */

    $window.load(function() {
        browserSize();
        Sidebar.init();
        navigation.init();
        scrollToTop();
        moveFeaturedImage();
        magnificPopupInit();
        logoAnimation.init();
        logoAnimation.update();
    });

    // /* ====== ON RESIZE ====== */

    function onResize() {
        browserSize();
        masonry.refresh();
        Sidebar.init();
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(update);
        }
        ticking = true;
    }

    function update() {
        logoAnimation.update();
        ticking = false;
    }

    $window.on('debouncedresize', onResize);

    $window.on('scroll', function() {
        latestKnownScrollY = window.scrollY;
        requestTick();
    });
    /* ====== HELPER FUNCTIONS ====== */



    /**
     * Detect what platform are we on (browser, mobile, etc)
     */

    function platformDetect() {
        $.support.touch = 'ontouchend' in document;
        $.support.svg = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false;
        $.support.transform = getSupportedTransform();

        $html
            .addClass($.support.touch ? 'touch' : 'no-touch')
            .addClass($.support.svg ? 'svg' : 'no-svg')
            .addClass(!!$.support.transform ? 'transform' : 'no-transform');
    }



    function browserSize() {
        windowHeight = $window.height();
        windowWidth = $window.width();
        documentHeight = $document.height();
        orientation = windowWidth > windowHeight ? 'portrait' : 'landscape';
    }



    function getSupportedTransform() {
        var prefixes = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform'];
        for (var i = 0; i < prefixes.length; i++) {
            if (document.createElement('div').style[prefixes[i]] !== undefined) {
                return prefixes[i];
            }
        }
        return false;
    }

    /**
     * Handler for the back to top button
     */
    function scrollToTop() {
        $('a[href="#top"]').click(function(event) {
            event.preventDefault();
            event.stopPropagation();

            $('html').velocity("scroll", 1000);
        });
    }

    function moveFeaturedImage() {
        if ($('article[class*="post"]').hasClass('entry-image--portrait') || $('article[class*="post"]').hasClass('entry-image--tall')) {
            $('.entry-featured').prependTo('article[class*="post"]');
        }
    }

    /**
     * function similar to PHP's empty function
     */

    function empty(data) {
        if (typeof(data) == 'number' || typeof(data) == 'boolean') {
            return false;
        }
        if (typeof(data) == 'undefined' || data === null) {
            return true;
        }
        if (typeof(data.length) != 'undefined') {
            return data.length === 0;
        }
        var count = 0;
        for (var i in data) {
            // if(data.hasOwnProperty(i))
            //
            // This doesn't work in ie8/ie9 due the fact that hasOwnProperty works only on native objects.
            // http://stackoverflow.com/questions/8157700/object-has-no-hasownproperty-method-i-e-its-undefined-ie8
            //
            // for hosts objects we do this
            if (Object.prototype.hasOwnProperty.call(data, i)) {
                count++;
            }
        }
        return count === 0;
    }

    /**
     * function to add/modify a GET parameter
     */

    function setQueryParameter(uri, key, value) {
        var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
        separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    function is_touch() {
        return $.support.touch;
    }

    function reorderSingleFooter() {
        if (!$body.hasClass('single')) {
            return;
        }

        var $related = $('.jp-relatedposts'),
            $jp = $('#jp-post-flair'),
            $author = $('.author-info'),
            $footer = $('.entry-footer');

        if ($jp.length) {
            if ($author.length) {
                $jp.insertBefore($author);
                if ($related.length) {
                    $related.insertAfter($author);
                }
            }
        }
    }
})(jQuery);