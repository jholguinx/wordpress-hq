jQuery(function(){
    jQuery('#reservation-form__car-select').on('change',function(){
        var owl = jQuery('.owl-carousel');
        var selectedVehicleClassId = jQuery('#reservation-form__car-select').val();
        var selectedVehicleSlide = jQuery('#hq-vehicle-wheelsberry-' + selectedVehicleClassId);
        owl.trigger('to.owl.carousel',[selectedVehicleSlide.attr('data-vehicle-class-index'),250]);
        refreshAutoplayTimeout();
    });
})
function refreshAutoplayTimeout(){
    var owl = jQuery('.owl-carousel');
    owl.data('owl.carousel').options.autoplayTimeout = 10000;
    owl.trigger('refresh.owl.carousel');
}