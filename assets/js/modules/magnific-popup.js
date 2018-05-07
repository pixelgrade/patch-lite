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
                titleSrc: function (item) {
                    var output = '';
                    if (typeof item.el.attr('data-alt') !== "undefined" && item.el.attr('data-alt') !== "") {
                        output += '<small>' + item.el.attr('data-alt') + '</small>';
                    }
                    return output;
                }
            }
        });
}
