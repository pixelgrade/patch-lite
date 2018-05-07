/**
 * Shared variables
 */
var ua                  = navigator.userAgent.toLowerCase(),
    platform            = navigator.platform.toLowerCase(),
    $window             = $(window),
    $document           = $(document),
    $html               = $('html'),
    $body               = $('body'),
    
    iphone              = platform.indexOf("iphone"),
    ipod                = platform.indexOf("ipod"),
    android             = platform.indexOf("android"),
    android_ancient     = (ua.indexOf('mozilla/5.0') !== -1 && ua.indexOf('android') !== -1 && ua.indexOf('applewebKit') !== -1) && ua.indexOf('chrome') === -1,
    apple               = ua.match(/(iPad|iPhone|iPod|Macintosh)/i),
    windows_phone       = ua.indexOf('windows phone') != -1,
    webkit              = ua.indexOf('webkit') != -1,

    firefox             = ua.indexOf('gecko') != -1,
    safari              = ua.indexOf('safari') != -1 && ua.indexOf('chrome') == -1,

    is_small            = $('.js-nav-trigger').is(':visible');

    windowHeight        = $window.height(),
    windowWidth         = $window.width(),
    documentHeight      = $document.height(),
    orientation         = windowWidth > windowHeight ? 'portrait' : 'landscape',

    latestKnownScrollY  = window.scrollY,
    ticking             = false;

;