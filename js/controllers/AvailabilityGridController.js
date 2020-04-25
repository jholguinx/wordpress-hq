import BaseController from "./BaseController";

class AvailabilityGridController extends BaseController{
    constructor(app) {
        super();
        this.app = app;
    }
    componentInit( app ){
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

    }
    onSuccess(response){
        this.app.setState({ vehicles: response.data.data });
    }
    onError(apiResponse, app){

    }
    availabilityData(){
        return this.apiConfig.getAvailabilityConfig(this.app.state.startDate, this.app.state.endDate, this.app.state.brandId);
    }
}
export default AvailabilityGridController;