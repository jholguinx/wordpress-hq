jQuery(function(){
    jQuery('#reservation-form__car-select').on('change',function(){
        var owl = jQuery('.owl-carousel');
        var selectedVehicleClassId = jQuery('#reservation-form__car-select').val();
        var selectedVehicleSlide = jQuery('#hq-vehicle-wheelsberry-' + selectedVehicleClassId);
        owl.trigger('to.owl.carousel',[selectedVehicleSlide.attr('data-vehicle-class-index'),250]);
    });
})