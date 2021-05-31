(function ($) {
    var formatDate = HQReservationFormData.HQFormatDate;
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
    jQuery('select[name="pick_up_location"]').on('change', function () {
        var id = '#hq_pick_up_custom_location';
        fadeCustom(id, $(this));
    });
    jQuery('select[name="return_location"]').on('change', function () {
        var id = '#hq_return_custom_location';
        fadeCustom(id, $(this));
    });
    jQuery("#hq_pick_up_location").on("change", function () {
        jQuery("#hq_return_location").val(jQuery("#hq_pick_up_location").val());
    });
})(jQuery);

function fadeCustom(id, element) {
    if (element.val() == 'custom') {
        jQuery(id).fadeIn();
        jQuery(id).prop('required', true);
    } else {
        jQuery(id).fadeOut();
        jQuery(id).prop('required', false);
    }
}