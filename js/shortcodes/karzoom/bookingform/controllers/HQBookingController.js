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
        );
    }
    onChangeSuggestion(value, app){
        app.setState({ suggestions: Parser.parseSuggestions() });
        /*
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
                    app.setState({ suggestions: Parser.parseSuggestions(error.data) })
                }
        );*/
    }
    getLocation( successCallback, failedCallback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition( successCallback );
        }else{
            failedCallback();
        }
    }
    centerMapOnSuggestionSelection(suggestion, app){
        /*
        this.connector.makeRequest(
            this.config.getPlaceDetails(suggestion),
            response => {
                app.setState({ mapCenter: Parser.parsePlaceDetails(response.data) });
            },
            error => {

            }
        );*/
        app.setState({ mapCenter: Parser.parsePlaceDetails().location });
    }
    onSelectLocationOnMap(location, app){
        app.setState({
            form: {
                ...app.state.form,
                brand: location.brand_id
            }
        });
        this.connector.makeRequest(
            this.config.getOnChangeLocationConfig(location),
            response => {
                const makes = Parser.parserMakes(response.data.data);
                const classes = Parser.parseVehicles(response.data.data);
                app.setState({
                    makes: makes,
                    vehicleClasses: classes,
                    form: {
                        ...app.state.form,
                        make: makes[0],
                        vehicleClass: classes[0].id
                    }
                });
            },
            error => {
                console.log('errr',error);
            }
        );
    }
    onChangeVehicleBrand(newType, app){
        const { form } = app.state;
        const { brand } = form;
        this.connector.makeRequest(
            this.config.getConfigOnChangeTypes(brand, newType),
            response => {
                app.setState({ vehicleClasses: Parser.parseVehicles(response.data.data) });
            },
            errors => {
                console.log(errors, 'err');
            }
        );
    }
}
export default HQBookingController;