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
    var pickupDate = jQuery('#hq_pick_up_date').datetimepicker(configPickup);
    var returnDate = jQuery('#hq_return_date').datetimepicker(configReturn);
    //remove events to avoid issue on dates changes
    pickupDate.off('blur');
    returnDate.off('blur');
    jQuery('#hq_pick_up_date').on("change", function(){
        jQuery('#hq_return_date').val(moment(jQuery('#hq_pick_up_date').val(), momentFormat).add(1, 'days').format(momentFormat));
    });
    jQuery('#hq-pick-up-location').on("change", function(){
        console.log('test', jQuery('#hq-pick-up-location').val());
        jQuery('#hq-return-location').val(jQuery('#hq-pick-up-location').val()).trigger('change');
    });
    jQuery(document).ready(function(){
        var today = moment().add(15,'minutes').format(momentFormat);
        var tomorrow = moment().add(15,'minutes').add(1,'days').format(momentFormat);
        jQuery('#hq_pick_up_date').val(today);
        jQuery('#hq_return_date').val(tomorrow
        );
    });
})(jQuery);