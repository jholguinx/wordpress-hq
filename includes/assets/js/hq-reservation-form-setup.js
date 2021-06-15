(function ($) {
    var formatDate = hqRentalsFrontEndDateformat;
    var configPickup = {
        format: formatDate,
        closeOnDateSelect: true,
        minDate: moment().format(formatDate),
        timepicker: true,
        step: 30,
    };
    var configReturn = {
        format: formatDate,
        closeOnDateSelect: true,
        minDate: moment().format(formatDate),
        timepicker: true,
        step: 30,
    };
    jQuery('#hq_pick_up_date').datetimepicker(configPickup);
    jQuery('#hq_return_date').datetimepicker(configReturn);
    // Custom locations inputs
})(jQuery);