/* ====== HELPER FUNCTIONS ====== */



/**
 * Detect what platform are we on (browser, mobile, etc)
 */

function platformDetect() {
  $.support.touch     = 'ontouchend' in document;
  $.support.svg       = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false;
  $.support.transform = getSupportedTransform();

  $html
    .addClass($.support.touch ? 'touch' : 'no-touch')
    .addClass($.support.svg ? 'svg' : 'no-svg')
    .addClass(!!$.support.transform ? 'transform' : 'no-transform');
}



function browserSize() {
    windowHeight    = $window.height();
    windowWidth     = $window.width();
    documentHeight  = $document.height();
    orientation     = windowWidth > windowHeight ? 'portrait' : 'landscape';
}  



function getSupportedTransform() {
  var prefixes = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform'];
  for(var i = 0; i < prefixes.length; i++) {
      if(document.createElement('div').style[prefixes[i]] !== undefined) {
          return prefixes[i];
      }
  }
  return false;
}

/**
 * Handler for the back to top button
 */
function scrollToTop() {
  $('a[href="#top"]').click(function(event){
    event.preventDefault();
    event.stopPropagation();

    $('html').velocity("scroll", 1000);
  });
}

function moveFeaturedImage() {
  if ($('article[class*="post"]').hasClass('entry-image--portrait') || $('article[class*="post"]').hasClass('entry-image--tall') ) {
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

  var $related  = $('.jp-relatedposts'),
      $jp       = $('#jp-post-flair'),
      $author   = $('.author-info'),
      $footer   = $('.entry-footer');

  if ($jp.length) {
    if ($author.length) {
      $jp.insertBefore($author);
      if ($related.length) {
        $related.insertAfter($author);
      }
    }
  }
}