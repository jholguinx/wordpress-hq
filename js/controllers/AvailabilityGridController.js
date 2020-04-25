import BaseController from "./BaseController";

class AvailabilityGridController extends BaseController{
    constructor(app, startDate, endDate, brandId) {
        super();
        this.startDate = startDate;
        this.endDate = endDate;
        this.brandId = brandId;
        this.app = app;
    }
    componentInit( app ){
        console.log(this.availabilityData());
        this.connector.makeRequest(
            this.availabilityData(),
            response => {
                console.log(response);
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
    onSuccess(response){
        this.app.setState({ vehicles: response.data.data });
    }
    onError(apiResponse, app){

    }
    availabilityData(){
        return this.apiConfig.getAvailabilityConfig(this.startDate, this.endDate, this.brandId);
    }
}
export default AvailabilityGridController;