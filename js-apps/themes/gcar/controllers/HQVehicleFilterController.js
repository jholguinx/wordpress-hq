import BaseController from "../../../controllers/BaseController";
import DateHelper from "../../../helpers/dates/DateHelper";


class HQVehicleFilterController extends BaseController{
    constructor(mainComponent) {
        super(mainComponent);
    }
    init(){
        this.app.setState({ loading: true });
        this.connector.makeRequest(
            this.apiConfig.getVehicleFormData(),
            response => {
                if(response.data.success){
                    this.app.setState({
                        fields: response.data.data.fields,
                        brands: response.data.data.brands,
                        vehicles: response.data.data.vehicles,
                        loading: false,
                        form: {
                            brand_id: response.data.data.brands[0].id,
                            pick_up_time: '12:00',
                            return_time: '12:00',
                            pick_up_date: DateHelper.nowDateForSystem(),
                            return_date: DateHelper.daysFromNowJustDate(1),
                            //vehicle_class_custom_fields:346,xxx,yyy,zzz
                            vehicle_class_custom_fields: [],
                            set_default_locations: 'true'
                        },
                    });
                }else{

                }
            },
            error => {
                console.log('error');
            }
        )
    }
    onChangeBrand(newValue){
        this.app.setState({
            form: {
                ...this.app.state.form,
                brand_id: newValue
            }
        })
    }
}
export default HQVehicleFilterController;