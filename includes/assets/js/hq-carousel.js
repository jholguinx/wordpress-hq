jQuery(document).ready(function(){
    jQuery('.owl-carousel').owlCarousel({
        loop:true,
        nav:true,
        items: 1,
        dots: true,
        navText: ['',''],
        mouseDrag: true,
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
    })
});
