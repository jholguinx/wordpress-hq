(function ($) {
    var formatDate = HQReservationFormData.HQFormatDate;
    var configPickup = {
        format: formatDate,
        closeOnDateSelect: true,
        minDate: moment().add(1, 'days').format(formatDate),
        defaultDate: moment().add(1, 'days').format(formatDate),
        timepicker: true,
        step:30,
    };
    var configReturn = {
        format: formatDate,
        closeOnDateSelect: true,
        minDate: moment().add(1, 'days').format(formatDate),
        defaultDate: moment().add(8, 'days').format(formatDate),
        timepicker: true,
        step:30,
    };
    // Init datetimepickers
    $('#hq_pick_up_date').datetimepicker(configPickup);
    $('#hq_return_date').datetimepicker(configReturn);
    // Custom locations inputs
    $('select[name="pick_up_location"]').on('change', function() {
        var id = '#hq_pick_up_custom_location';
        fadeCustom(id,$(this));
    });
    $('select[name="return_location"]').on('change', function() {
        var id = '#hq_return_custom_location';
        fadeCustom(id,$(this));
    });
})(jQuery);
function fadeCustom(id, element){
    if (element.val() == 'custom') {
        jQuery(id).fadeIn();
        jQuery(id).prop('required',true);
    } else {
        jQuery(id).fadeOut();
        jQuery(id).prop('required',false);
    }
}