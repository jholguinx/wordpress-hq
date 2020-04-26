
class ApiEndpointHandler{
    /*This comes from WP*/
    static baseURL = baseUrl;
    static endpoints = {
          availabilityEndpoint : 'wp-json/hqrentals/shortcodes/availability/'
    };
    static getAvailabilityEndpoint(){
        return ApiEndpointHandler.baseURL + ApiEndpointHandler.endpoints.availabilityEndpoint
    }
}
export default ApiEndpointHandler;
