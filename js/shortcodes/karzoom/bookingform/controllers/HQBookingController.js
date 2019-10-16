import ApiConnector from "../../helpers/api/ApiConnector";
import ApiConfigurationManager from "../../helpers/api/ApiConfigurationManager";
import Parser from "../../helpers/api/Parser";
class HQBookingController{
    constructor() {
        this.connector = new ApiConnector();
        this.config = new ApiConfigurationManager();
    }

    componentInit(app){
        this.connector.makeRequest(
            this.config.getInitConfig(),
            response => {
                if(response.data.success){
                    app.setState({ brands: Parser.parseBrands(response.data.data) });
                }else{
                    app.setState({ errors: 'there was an issue' });
                }
            },
            error => {
                app.setState({ errors: 'there was an issue' });
            }
        )
    }
    onChangeSuggestion(){
    }
    getLocation( successCallback, failedCallback) {
        if (navigator.geolocation) {
            console.log('tre');
            navigator.geolocation.getCurrentPosition( successCallback );
            console.log('tredasdads');
        }else{
            console.log('tdasdas');
            failedCallback();
        }
    }
}
export default HQBookingController;