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
    addressField = document.querySelector("#hq-places-field");
    // Create the autocomplete object, restricting the search predictions to
    // addresses in the US and Canada.
    autocomplete = new google.maps.places.Autocomplete(addressField, {
        componentRestrictions: { country: ["us"] },
        fields: ["address_components", "geometry"],
        types: ["address","establishment"],
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
    const dateFormat = hqRentalsSystemDateformat.split(' ')[0];
    const timeFormat = hqRentalsSystemDateformat.split(' ')[1];
    const dateConfig  = {
        dateFormat: dateFormat,
        disableMobile: true,
    };
    const timeConfig = {
        dateFormat: timeFormat,
        disableMobile: true,
        enableTime:true,
        noCalendar: true,
        altFormat: timeFormat,
        altInput: timeFormat,
        ariaDateFormat: timeFormat,
        time_24hr: true
    }
    flatpickr("#hq-times-pick-up-date", dateConfig);
    flatpickr("#hq-times-pick-up-time", timeConfig);
    flatpickr("#hq-times-return-date", dateConfig);
    flatpickr("#hq-times-return-time", timeConfig);
});