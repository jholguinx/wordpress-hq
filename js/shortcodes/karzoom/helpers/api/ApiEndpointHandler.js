
class ApiEndpointHandler{
    /*Get this from wordpress - Somewhere*/
    getBaseUrl(){
        return HQMapFormShortcode.baseURL;
    }
    getInitEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/bookingform/';
    }

    getBrandEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/bookingform/';
    }
    getTypesAndVehiclesEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/vehicle-types/';
    }
    getGoogleAutocompleteEndpoint(){
        return '/wp-json/hqrentals/google/autocomplete/';
    }
    getGooglePlaceDetailEndpoint(){
        return '/wp-json/hqrentals/google/place/';
    }

}
export default ApiEndpointHandler;
