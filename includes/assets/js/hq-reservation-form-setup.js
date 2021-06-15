(function ($) {
    var formatDate = hqRentalsTenantDatetimeFormat;
    var momentFormat = hqMomentDateFormat;
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
    jQuery('#hq_pick_up_date').on("change", function(){
        jQuery('#hq_return_date').val(moment(jQuery('#hq_pick_up_date').val(), momentFormat).add(1, 'days').format(momentFormat));
    });
    jQuery('#hq-pick-up-location').on("change", function(){
        jQuery('#hq-return-location').val(jQuery('#hq-pick-up-location').val());
    });
    jQuery(document).ready(function(){
        var today = moment().add(15,'minutes').format(momentFormat);
        var tomorrow = moment().add(15,'minutes').add(1,'days').format(momentFormat);
        jQuery('#hq_pick_up_date').val(today);
        jQuery('#hq_return_date').val(tomorrow);
    });
})(jQuery);