/*
 * Api Configuration Manager
 */

import ApiEndpointHandler from './ApiEndpointHandler';


class ApiConfigurationManager {
    constructor() {
        this.endpoints = new ApiEndpointHandler();
        this.placesDefaultConfig = {
            key: 'AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE',
            input:'',
            language: 'en'
        };
    }
    getInitConfig(){
        return {
            url: this.endpoints.getInitEndpoint(),
            method: 'get',
            headers: {
                'Content-type': 'application/json'
            }
        };
    }
    getPlacesConfig(newInput){
        return {
            url: this.endpoints.getGoogleAutocompleteEndpoint(),
            params: {
                input: newInput
            },
            method: 'get'
        };
    }
    getPlaceDetails(place){
        return {
            url: this.endpoints.getGooglePlaceDetailEndpoint(),
            params: {
                place_id: place.place_id
            },
            method: 'get'
        };
    }
    getOnChangeLocationConfig(location,brand){
        const brand_id = (brand) ? location : location.brand_id;
        return {
            url: this.endpoints.getTypesAndVehiclesEndpoint(),
            method: 'get',
            params:{
                brand_id: brand_id,
                custom_field: 'f236'
            }
        };
    }
    getConfigOnChangeTypes(brandId, customField){
        return {
            url: this.endpoints.getTypesAndVehiclesEndpoint(),
            method: 'get',
            params:{
                brand_id: brandId,
                custom_field: 'f236',
                custom_field_value: customField
            }
        };
    }
}

export default ApiConfigurationManager;