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
        return this.getBaseUrl() + 'wp-json/hqrentals/shortcodes/bookingform/';
    }
    getGoogleAutocompleteEndpoint(){
        return 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
    }

}
export default ApiEndpointHandler;
