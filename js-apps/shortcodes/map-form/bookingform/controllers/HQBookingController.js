import ApiConnector from "../../helpers/api/ApiConnector";
import ApiConfigurationManager from "../../helpers/api/ApiConfigurationManager";
import Parser from "../../helpers/api/Parser";
import GeoLocationHelper from '../../helpers/utils/GeoLocationHelper';
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
                    let brands = Parser.parseBrands(response.data.data.brands);
                    app.setState({
                        locations: Parser.parseLocations(response.data.data.locations),
                        brands: brands
                    });
                    this.getLocation( (position) => {
                        const { coords } = position;
                        const { latitude, longitude } = coords;
                        app.setState({
                            mapCenter: {
                                lat: latitude,
                                lng: longitude
                            },
                            enabledLocationTracking: true,
                            brands: this.sortBrandsByUserLocation(coords, brands)
                        });
                    }, (error) => console.log('no navigator')
                );
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
        this.connector.makeRequest(
            this.config.getPlacesConfig(value),
                response => {
                    if(response.data){
                           app.setState({ suggestions: Parser.parseSuggestions(response.data.data.predictions) });
                    }
                },
                error => {
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
    centerMapOnSuggestionSelection(suggestion, app){
        this.connector.makeRequest(
            this.config.getPlaceDetails(suggestion),
            response => {
                app.setState({ mapCenter: Parser.parsePlaceDetails(response.data.data.place) });
            },
            error => {

            }
        );
    }
    onSelectLocationOnMap(location, app, brand){
        this.connector.makeRequest(
            this.config.getOnChangeLocationConfig(location, brand),
            response => {
                const makes = Parser.parserMakes(response.data.data);
                const classes = Parser.parseVehicles(response.data.data);
                app.setState({
                    makes: makes,
                    vehicleClasses: classes,
                    form: {
                        ...app.state.form
                    }
                });
            },
            error => {
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
            }
        );
    }
    sortBrandsByUserLocation(userLocation, brands){
        return brands.sort((brandA, brandB) => {
            const locationA = brandA.locations[0].coordinates;
            const locationB = brandB.locations[0].coordinates;
            const userDistanceA = GeoLocationHelper.getDistanceBetweenPoints(userLocation,locationA);
            const userDistanceB = GeoLocationHelper.getDistanceBetweenPoints(userLocation,locationB);
            if(userDistanceA < userDistanceB){
                return -1;
            }
            if(userDistanceA > userDistanceB){
                return 1;
            }
            return 0;
        });
    }
}
export default HQBookingController;