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
        }
    }
    getInitConfig(){
        return {
            url: this.endpoints.getInitEndpoint(),
            method: 'get',
            headers: {
                'Content-type': 'application/json'
            }
        }
    }
    getPlacesConfig(newInput){
        return {
            url: this.endpoints.getGoogleAutocompleteEndpoint(),
            params: {
                ...this.placesDefaultConfig,
                input: newInput
            },
            data: {
                ...this.placesDefaultConfig,
                input: newInput,
                componenst: 'country:ve'
            },
            method: 'get',
            headers: {
                'Content-Type' : 'application/json'
            }
        }
    }
    getPlaceDetails(place){
        return {
            url: this.endpoints.getGooglePlaceDetailEndpoint(),
            params: {
                ...this.placesDefaultConfig,
                place_id: place.place_id
            },
            method: 'get',
            headers: {
                'Content-Type' : 'application/json'
            }
        }
    }
    getOnChangeLocationConfig(location){
        return {
            url: this.endpoints.getGooglePlaceDetailEndpoint(),
            params: {
                ...this.placesDefaultConfig,
                place_id: place.place_id
            },
            method: 'get',
            headers: {
                'Content-Type' : 'application/json'
            }
        };
    }

}

export default ApiConfigurationManager;