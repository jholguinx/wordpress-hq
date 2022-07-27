jQuery(document).ready(function(){
    jQuery('.owl-carousel').owlCarousel({
        loop:true,
        nav:true,
        items: 1,
        dots: false,
        responsiveClass: true,
        navText: ['',''],
        mouseDrag: false,
        autoHeight: true,
        autoplay: true,
        /*
        responsive : {
            // breakpoint from 0 up
            0 : {
                option1 : value,
                option2 : value,
                ...
            },
            // breakpoint from 480 up
            480 : {
                option1 : value,
                option2 : value,
                ...
            },
            // breakpoint from 768 up
            768 : {
                option1 : value,
                option2 : value,
                ...
            }
        }*/
    });
    jQuery('.hq-tab').on('click',function (e){
        e.preventDefault();
        var pos = jQuery(this).attr('data-position');
        jQuery('.hq-tab').removeClass('active');
        jQuery(this).addClass('active');
        jQuery(".owl-carousel").trigger("to.owl.carousel", [pos, 1])
    });
    jQuery('.owl-carousel').on('changed.owl.carousel', function(event) {
        jQuery('.hq-tab').removeClass('active');
        jQuery('.hq-tap-pos-'+event.page.index).addClass('active');
    });
    var form = jQuery('.hq-reservation-form-wrapper');
    if(form.length){
        var scroll = new SmoothScroll('a[href*="#"]',{
            speed: 1000,
            /*
            offset: function (anchor, toggle) {
                return -350;
            },*/
        });
    }
});
