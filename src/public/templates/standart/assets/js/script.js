$(document).ready(function($) {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
        $(".palka").hide();
    }
    else {
        $(".navbar").addClass("nav-height");
    }

    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
        $(window).scroll(function() {
            var y = $(this).scrollTop();

            if($(this).scrollTop() > 72) {
                $('body').addClass('fixed-body');
                $('.navbar').removeClass('nav-height');
                $('.navbar').addClass('is-scrolling');
            }
            else {
                $('.navbar').addClass('nav-height');
                $('.navbar').removeClass('is-scrolling');
                $('body').css('margin-top', '-68px');
                $('body').removeClass('fixed-body');
                $('body').css('margin-top', '0px');
            }
        });
    }
});