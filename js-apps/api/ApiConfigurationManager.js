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
            params: BaseAdapter.parseDataForAvailability(startDate, endDate, brandId),
            timeout: 30000
        };
    }
    getAvailabilityDatesConfig(form){
        return {
            url: ApiEndpointHandler.getAvailabilityDates(),
            method: 'get',
            params: this.cleanDataBeforeCall(form),
            timeout: 30000
        };
    }
    getVehicleFormData(form){
        return {
            url: ApiEndpointHandler.getVehicleFormFilterEndpoint(),
            method: 'get',
            params: this.cleanDataBeforeCall(form),
            timeout: 30000
        };
    }
    cleanDataBeforeCall(form){
        let data = {};
        for (var propName in form) {
            if(form[propName]){
                data[propName] = form[propName];
            }
        }
        return data;
    }
}

export default ApiConfigurationManager;