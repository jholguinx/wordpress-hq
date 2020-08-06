import BaseController from "../../../controllers/BaseController";
import DateHelper from "../../../helpers/dates/DateHelper";


class HQVehicleFilterController extends BaseController{
    constructor(mainComponent) {
        super(mainComponent);
    }
    init(){
        this.app.setState({ loading: true });
        this.connector.makeRequest(
            this.apiConfig.getVehicleFormData(this.app.state.form),
            response => {
                if(response.data.success){
                    this.app.setState({
                        fields: response.data.data.fields,
                        brands: response.data.data.brands,
                        vehicles: response.data.data.vehicles,
                        loading: false,
                        form: this.setFormValuesOnInit(response),
                        locations: response.data.data.locations
                    });
                }else{
                    this.app.setState({
                        loading:false
                    });
                }
            },
            error => {
                this.app.setState({
                    loading:false
                });
            }
        )
    }
    onChangeLocation(newValue){
        this.app.setState({
            form: {
                ...this.app.state.form,
                pick_up_location: newValue,
                return_location: newValue
            }
        });
    }
    onChangeField(field, value) {
        let dataUpdate = {...this.app.state.form};
        dataUpdate[field.form_name] = value;
        this.app.setState({
            form:dataUpdate
        });
    }

    setFormValuesOnInit(response){
        const fields = response.data.data.fields;
        let data = {
            pick_up_time: '12:00',
            return_time: '12:00',
            pick_up_location: response.data.data.locations[0].id,
            return_location: response.data.data.locations[0].id,
            pick_up_date: DateHelper.nowDateForSystem(),
            return_date: DateHelper.daysFromNowJustDate(30),
            //vehicle_class_custom_fields:346,xxx,yyy,zzz
            vehicle_class_custom_fields: this.getVehicleClassCustomFieldValue(fields),
        };
        fields.forEach( field => {
            data[field.form_name] = Object.entries(field.options)[0][0];
        } )
        return data;
    }
    getVehicleClassCustomFieldValue(fields){
        let value = '';
        fields.forEach((field, index) => {
            if(index === fields.length - 1){
                value += field.id;
            }else{
                value += field.id + ',';
            }
        });

        return value;
    }
    onSubmitForm(){
        this.app.setState({
            loading: true
        });
        this.connector.makeRequest(
            this.apiConfig.getAvailabilityDatesConfig(this.app.state.form),
            response => {
                if(response.data.success){
                    this.app.setState({
                        vehicles: response.data.data.vehicles,
                        loading:false
                    });
                }else{
                    this.app.setState({
                        loading:false,
                        vehicles: [],
                    });
                }
            },
            error => {
                this.app.setState({
                    loading:false,
                    vehicles: [],
                });
            }
        )
    }
}
export default HQVehicleFilterController;