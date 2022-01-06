jQuery(document).ready(function(){
    jQuery('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        items: 1,
        dots: false
    });
    jQuery('.hq-tab').on('click',function (e){
        var pos = jQuery(this).attr('data-position');
        jQuery('.hq-tab').removeClass('active');
        jQuery(this).addClass('active');
        jQuery(".owl-carousel").trigger("to.owl.carousel", [pos, 1])
    });
});
