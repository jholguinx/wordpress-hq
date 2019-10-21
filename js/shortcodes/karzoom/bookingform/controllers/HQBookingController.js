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
                    app.setState({
                        brands: Parser.parseBrands(response.data.data.brands),
                        locations: Parser.parseLocations(response.data.data.locations)
                    });
                }else{
                    app.setState({ errors: 'there was an issue' });
                }
            },
            error => {
                app.setState({ errors: 'there was an issue' });
            }
        )
    }
    onChangeSuggestion(value, app){
        this.connector.makeRequest(
            this.config.getPlacesConfig(value),
                response => {
                if(response.data){
                       app.setState({ suggestions: Parser.parseSuggestions(response.data) })
                }
                    //THIS should be removed when cors issue is gone
                    app.setState({ suggestions: Parser.parseSuggestions(response.data) })
                },
                error => {
                    console.log(error, 'error');
                }
        );
    }
    getLocation( successCallback, failedCallback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition( successCallback );
        }else{
            failedCallback();
        }
    }
}
export default HQBookingController;