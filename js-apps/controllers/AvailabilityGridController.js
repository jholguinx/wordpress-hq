import BaseController from "./BaseController";
import AvailabilityAdapter from "../adapters/AvailabilityAdapter";

class AvailabilityGridController extends BaseController{
    constructor(app) {
        super();
        this.app = app;
        this.state = app.state;
    }
    changeStateOfLoader(){
        this.app.setState({ isLoading: ! this.app.state.isLoading });
    }
    initState(){
        this.app.setState({
            title: availabilityGridTitle,
            integrationURL: availabilityGridIntegrationPage,
            websiteBaseURL : baseUrl,
            brands : hqRentalsBrands,
        })
    }
    componentRefreshData( ){
        this.changeStateOfLoader();
        this.connector.makeRequest(
            this.availabilityData(),
            response => {
                if(response.data.success){
                    this.onSuccess(response);
                }else{
                    this.onError(response);
                }
            },
            error => {
                this.onError(error);
            }
        );
    }
    onChangeDates(dateRange){
        this.app.setState({ dateRange : dateRange });
        this.componentRefreshData();

    }
    onChangeBranch(brand){
        const { id } = brand;
        this.app.setState({ brandId: id });
        setTimeout(this.componentRefreshData, 250);
    }
    onSuccess(response){
        this.app.setState({ vehiclesPerRow: AvailabilityAdapter.adaptAvailabilityResponseForComponent(response.data.data) });
        this.changeStateOfLoader();
    }
    onError(apiResponse, app){
        this.changeStateOfLoader();
    }
    availabilityData(){
        return this.apiConfig.getAvailabilityConfig(this.app.state.startDate, this.app.state.endDate, this.app.state.brandId);
    }
}
export default AvailabilityGridController;