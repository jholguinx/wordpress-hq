/*
 * Api Configuration Manager
 */

import ApiEndpointHandler from './ApiEndpointHandler';
import BaseAdapter from '../adapters/BaseAdapter';


class ApiConfigurationManager {
    constructor() {
        this.endpoints = new ApiEndpointHandler();
    }
    getAvailabilityConfig(startDate, endDate, brandId){
        return {
            url: ApiEndpointHandler.getAvailabilityEndpoint(),
            method: 'get',
            params: BaseAdapter.parseDataForAvailability(startDate, endDate, brandId)
        };
    }
}

export default ApiConfigurationManager;