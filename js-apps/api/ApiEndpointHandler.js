
class ApiEndpointHandler{
    /*This comes from WP*/
    static baseURL = hqSite;
    static endpoints = {
        availabilityEndpoint : 'wp-json/hqrentals/shortcodes/availability/',
        vehicleFormEndpoint : 'wp-json/hqrentals/shortcodes/vehicle-filter',
        availabilityDates : 'wp-json/hqrentals/shortcodes/availability/dates'

    };
    static getAvailabilityEndpoint(){
        return ApiEndpointHandler.baseURL + ApiEndpointHandler.endpoints.availabilityEndpoint
    }
    static getVehicleFormFilterEndpoint(){
        return ApiEndpointHandler.baseURL + ApiEndpointHandler.endpoints.vehicleFormEndpoint
    }
    static getAvailabilityDates(){
        return ApiEndpointHandler.baseURL + ApiEndpointHandler.endpoints.availabilityDates
    }
}
export default ApiEndpointHandler;
