! function(o) {
    "use strict";
    o(window).on("load", function() {
        o(".loader-inner").fadeOut(), o(".loader").delay(200).fadeOut("slow")
    }), o(function() {
        o(window).scroll(function() {
            o(this).scrollTop() > 100 ? o(".scroll-to-top").addClass("active") : o(".scroll-to-top").removeClass("active")
        })
    }), o("a.scroll").smoothScroll({
        speed: 800,
        offset: -71
    }), o(".popup-youtube, .popup-vimeo").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: !1,
        fixedContentPos: !1
    }), jarallax(document.querySelectorAll(".jarallax"), {
        speed: .5,
        disableParallax: /iPad|iPhone|iPod|Android/,
        disableVideo: /iPad|iPhone|iPod|Android/
    })
}(jQuery);