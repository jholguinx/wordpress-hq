const messages = {
    noResponseOnCall: "We didn't receive a response from our servers. Please try again.",
    somethingWrongWithTheSetupOfTheCall: 'There was a problem internally with your request. Please try again.',
    status500Message: 'There was an internal problem, please contact support.'
};

class ApiErrorHandler {
    constructor() {
        this.message = messages;
    }
    getErrorMessage(error){
        if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            //console.log(error.response.status);
            //console.log(error.response.headers);
            if( error.response.data.errors ){
                return error.response.data.errors.error_message;
            } else if( error.response.status > 499 ){
                return (error.response.data.message) ? error.response.data.message : this.message.status500Message;
            }else{
                return error.response.data.message;
            }
        } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            return this.message.noResponseOnCall;

        } else {
            // Something happened in setting up the request that triggered an Error
            return this.message.somethingWrongWithTheSetupOfTheCall;
        }
    }
    getErrorMessageOnSuccessfullCall(error){
        return error.error_message;
    }
}
export default ApiErrorHandler;