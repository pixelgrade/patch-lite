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