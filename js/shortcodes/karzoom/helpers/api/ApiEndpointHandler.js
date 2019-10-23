const endpoints = {

};

class ApiEndpointHandler{
    constructor(){
        this.endpoints = endpoints;
    }
    /*Get this from wordpress - Somewhere*/
    getBaseUrl(){
        return 'http://karzoom.test/';
    }
    getInitEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/bookingform/';
    }

    getBrandEndpoint(){
        console.log('2');
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/bookingform/';
    }
    getTypesAndVehiclesEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/vehicle-types/';
    }
    getGoogleAutocompleteEndpoint(){
        return 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
    }
    getGooglePlaceDetailEndpoint(){
        return 'https://maps.googleapis.com/maps/api/place/details/json';
    }

}
export default ApiEndpointHandler;
