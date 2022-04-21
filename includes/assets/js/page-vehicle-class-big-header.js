dayjs.extend(window.dayjs_plugin_customParseFormat);
var rateType12 = 'rx2fhigt-o79s-9v8g-6ynq-qul5c08mglfe';
var rateType24 = 'ghpaspdi-i9tq-rfyh-b4f1-ddrqqepxurhz';
var rateType36 = 'tioiivab-hkqo-i78w-qf24-allupspu5fyj';
var dateFormatMoment = 'DD-MM-YYYY';
jQuery(document).ready(function (){
    jQuery('#pick-up-location').on('change', function (){
        jQuery('#hq-return-location').val(jQuery(this).val());

    });
    jQuery('#reservation_interval').on('change',function(){
        var interval = jQuery(this).val();
        updateReturnDate(interval);

    });
    // init pickup date
    jQuery('#hq_pick_up_date_interval').val(dayjs().add(1, 'day').format(dateFormatMoment));
    var configDateTimeConfig = {
        format: hqRentalsTenantDatetimeFormat.split(' ')[0],
        timepicker: false,
    };
    jQuery("#hq_pick_up_date_interval").datetimepicker(configDateTimeConfig);
    jQuery('#hq_pick_up_date_interval').on('change', function (){
        var interval = jQuery('#reservation_interval').val();
        updateReturnDate(interval)
    });
});
function updateReturnDate(interval){
    if(interval === '365_day'){
        jQuery('#rate-type').val(rateType12);
        jQuery('#rate-type-id').val(1);
        addYearsToReturn(1);
    }
    if(interval === '730_day'){
        jQuery('#rate-type').val(rateType24);
        jQuery('#rate-type-id').val(2);
        addYearsToReturn(2);
    }
    if(interval === '1095_day'){
        jQuery('#rate-type').val(rateType36);
        jQuery('#rate-type-id').val(3);
        addYearsToReturn(3);
    }
}
function addMonthsToReturn(months){
    var pickup = jQuery('#hq_pick_up_date_interval');
    jQuery('#hq_return_date').val(
        dayjs(pickup.val(), dateFormatMoment).add(months * 30,'day').format(dateFormatMoment)
    );
}
function addYearsToReturn(years){
    var pickup = jQuery('#hq_pick_up_date_interval');
    jQuery('#hq_return_date').val(
        dayjs(pickup.val(), dateFormatMoment).add(years,'year').format(dateFormatMoment)
    );
}