/*
 * Api Configuration Manager
 */

import ApiEndpointHandler from './ApiEndpointHandler';


class ApiConfigurationManager {
    constructor() {
        this.endpoints = new ApiEndpointHandler();
    }
    getInitConfig(){
        return {
            url: this.endpoints.getBrandEndpoint(),
            method: 'get'
        }
    }

}

export default ApiConfigurationManager;