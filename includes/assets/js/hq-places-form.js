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
function initPlacesForm() {
    const center = { lat: 26.7751182, lng: -82.2354601 };
    const defaultBounds = {
        north: center.lat + 2,
        south: center.lat - 2,
        east: center.lng + 2,
        west: center.lng - 2,
    };
    addressField = document.querySelector("#hq-places-field");
    // Create the autocomplete object, restricting the search predictions to
    // addresses in the US and Canada.
    autocomplete = new google.maps.places.Autocomplete(addressField, {
        bounds: defaultBounds,
        origin: center,
        strictBounds: true,
        componentRestrictions: { country: ["us"] },
        fields: ["address_components"],
        types: ["address"],
    });
    //address1Field.focus();
    addressField.focus();
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener("place_changed", updateReturnLocation);
}
function updateReturnLocation(){
    document.querySelector("#hq-return-location-custom").value = document.querySelector("#hq-places-field").value;
}
jQuery(document).ready(function(){
    const dateFormat = hqMomentDateFormat;
    const dateConfig  = {
        dateFormat: dateFormat,
    };
    setDefaults(dateFormat);
    jQuery("#hq-times-pick-up-date").datetimepicker(dateConfig);
    jQuery("#hq-times-return-date").datetimepicker(dateConfig);
    jQuery("#hq-times-pick-up-date").on("change",function(){
        var newDate = dayjs(jQuery("#hq-times-pick-up-date").val(), dateFormat).add(1, 'day').format(dateFormat);
        jQuery("#hq-times-return-date").val(newDate);
    });
    jQuery("#hq-times-pick-up-time").on("change",function(){
        jQuery("#hq-times-return-time").val(jQuery("#hq-times-pick-up-time").val());
    });
    jQuery("#hq-pick-up-location").on("change",function() {
        if (jQuery("#hq-pick-up-location").val() === "custom") {

        }
    });
    jQuery("#hq-return-location").on("change",function(){

    });
});
function setDefaults(dateFormat){
    var newDate = dayjs().format(dateFormat);
    var tomorrowDate = dayjs().add(1, 'day').format(dateFormat);
    jQuery("#hq-times-pick-up-date").val(newDate);
    jQuery("#hq-times-return-date").val(tomorrowDate);
}