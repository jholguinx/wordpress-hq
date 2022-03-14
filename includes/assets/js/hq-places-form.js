dayjs.extend(window.dayjs_plugin_customParseFormat)
// This sample uses the Places Autocomplete widget to:
// 1. Help the user select a place
// 2. Retrieve the address components associated with that place
// 3. Populate the form fields with those address components.
// This sample requires the Places library, Maps JavaScript API.
// Include the libraries=places parameter when you first load the API.
// For example: <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
let autocomplete;
let addressField;
let addressFieldReturn;
function initPlacesForm() {
    //26.7751182,-82.2354601
    //2
    //us
    const lat = (googleMapCenter) ? googleMapCenter.split(',')[0] : null;
    const lng = (googleMapCenter) ? googleMapCenter.split(',')[1] : null;
    const country = (googleCountry) ? googleCountry : "us";
    const center = (lat && lng) ? { lat, lng} : null;
    const defaultBounds = (googleMapAddressRadius) ? {
        north: parseFloat(lat) + parseFloat(googleMapAddressRadius),
        south: parseFloat(lat) - parseFloat(googleMapAddressRadius),
        east: parseFloat(lng) + parseFloat(googleMapAddressRadius),
        west: parseFloat(lng) - parseFloat(googleMapAddressRadius),
    } : null;
    addressField = document.querySelector("#pick-up-location-custom");
    addressFieldReturn = document.querySelector("#return-location-custom");
    // Create the autocomplete object, restricting the search predictions to
    // addresses in the US and Canada.
    let autoConfig = {
        bounds: defaultBounds,
        origin: center,
        strictBounds: true,
        componentRestrictions: { country: [country] },
        fields: ["address_components"],
        types: ["address"],
    };
    autocomplete = new google.maps.places.Autocomplete(addressField, autoConfig);
    autocompleteReturn = new google.maps.places.Autocomplete(addressFieldReturn, autoConfig);
    //address1Field.focus();
    addressField.focus();
    addressFieldReturn.focus();
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    //autocomplete.addListener("place_changed", updateReturnLocation);
}
function updateReturnLocation(){
    document.querySelector("#hq-return-location-custom").value = document.querySelector("#hq-places-field").value;
}
jQuery(document).ready(function(){
    const dateFormat = hqMomentDateFormat;
    const minDays = minimumDayRentals;
    const dateConfig  = {
        dateFormat: hqRentalsTenantDatetimeFormat,
        minDate: 0,
        format:hqRentalsTenantDatetimeFormat,
    };
    setDefaults(dateFormat, minDays);
    jQuery("#hq-times-pick-up-date").datetimepicker(dateConfig);
    jQuery("#hq-times-return-date").datetimepicker(dateConfig);
    jQuery("#hq-times-pick-up-date").on("change",function(){
        const dateFormatMoment = hqMomentDateFormat;
        var newDate = dayjs( jQuery("#hq-times-pick-up-date").val(), dateFormatMoment ).add(minimumDayRentals, 'day').format(dateFormatMoment);
        jQuery("#hq-times-return-date").val(newDate);
    });
    jQuery("#hq-times-pick-up-time").on("change",function(){
        jQuery("#hq-times-return-time").val(jQuery("#hq-times-pick-up-time").val());
    });
    jQuery("#hq-pick-up-location").on("change",function() {
        if (jQuery("#hq-pick-up-location").val() === "custom") {
            jQuery('.hq-pickup-custom-location').slideDown();
        }else{
            jQuery('.hq-pickup-custom-location').slideUp();
        }
    });
    jQuery("#hq-return-location").on("change",function(){
        if (jQuery("#hq-return-location").val() === "custom") {
            jQuery('.hq-return-custom-location').slideDown();
        }else{
            jQuery('.hq-return-custom-location').slideUp();
        }
    });
});
function setDefaults(dateFormat,minimumDayRentals){
    var newDate = dayjs().add(15, 'minutes').add(2,'hours').format(dateFormat);
    var tomorrowDate = dayjs().add(minimumDayRentals, 'day').add(15, 'minutes').add(2,'hours').format(dateFormat);
    if(hqRentalsTenantDatetimeFormat && hqCarRentalSettingDefaultReturnTime){
        newDate = newDate.split(' ')[0] + ' ' + hqCarRentalSettingDefaultPickupTime.setting;
        tomorrowDate = tomorrowDate.split(' ')[0] + ' ' + hqCarRentalSettingDefaultReturnTime.setting;
    }
    jQuery("#hq-times-pick-up-date").val(newDate);
    jQuery("#hq-times-return-date").val(tomorrowDate);
}