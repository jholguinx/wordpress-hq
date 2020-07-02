jQuery(document).ready(function(){
    var configDateTimeConfig = {
        format: hqRentalsTenantDatetimeFormat,
    };
    jQuery("#hq-pickup-date-time-input").datetimepicker(configDateTimeConfig);
    jQuery("#hq-return-date-time-input").datetimepicker(configDateTimeConfig);
});