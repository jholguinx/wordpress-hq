import axios from 'axios';

class ApiConnector {
    constructor() {
        this.config = {
            // `url` is the server URL that will be used for the request
            url: '',

            // `method` is the request method to be used when making the request
            method: 'get', // default
            // `timeout` specifies the number of milliseconds before the request times out.
            // If the request takes longer than `timeout`, the request will be aborted.
            timeout: 10000, // default is `0` (no timeout)

            // `auth` indicates that HTTP Basic auth should be used, and supplies credentials.
            // This will set an `Authorization` header, overwriting any existing
            // `Authorization` custom headers you have set using `headers`.
            // `responseType` indicates the type of data that the server will respond with
            // options are 'arraybuffer', 'blob', 'document', 'json', 'text', 'stream'
            responseType: 'json', // default

            // `maxContentLength` defines the max size of the http response content in bytes allowed
            maxContentLength: 2000,

            // `maxRedirects` defines the maximum number of redirects to follow in node.js.
            // If set to 0, no redirects will be followed.
            maxRedirects: 5, // default
        }
    }

    makeRequest( customConfig = null, successCallback, failedCallback ) {
        if ( customConfig ) {
            axios( this.overrideDefaultConfig( customConfig ) ).then( ( response ) => {
                successCallback( response );
            } ).catch( ( error ) => {
                failedCallback( error );
            } );
        } else {
            axios( this.config ).then( ( response ) => {
                successCallback( response );
            } ).catch( ( error ) => {
                failedCallback( error );
            } );
        }
    }
    overrideDefaultConfig( customConfig ) {
        Object.entries( customConfig ).forEach( ( entry ) => {
            if ( entry ) {
                this.config[ entry[ 0 ] ] = entry[ 1 ];
            }
        } );
        return {
            ...this.config
        }
    }

}

export default ApiConnector;