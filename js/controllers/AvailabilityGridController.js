import BaseController from "./BaseController";

class AvailabilityGridController extends BaseController{
    constructor(app) {
        super();
        this.app = app;
        this.state = app.state;
    }
    changeStateOfLoader(){
        console.log('change');
        //this.app.setState({ isLoading: ! this.state.isLoading });
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
    onSuccess(response){
        this.app.setState({ vehiclesPerRow: this.arrayHelper.chunck(response.data.data) });
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