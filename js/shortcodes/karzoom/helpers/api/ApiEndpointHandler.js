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
    getBrandEndpoint(){
        return this.getBaseUrl() + 'wp-json/hqrentals/brands/';
    }

}
export default ApiEndpointHandler;
