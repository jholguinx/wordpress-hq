import React, {Component} from 'react';
import HQVehicleFilterController from "../../controllers/HQVehicleFilterController";
import DisplayValidator from "../../../../helpers/render/DisplayValidator";
import VehicleCard from "../../components/cars/VehicleCard";
import Select from "../../components/inputs/Select";
import SubmitButton from '../../components/buttons/SubmitButton'
import EmptyListMessage from "../../components/messages/EmptyListMessage";
import ImageSpinner from "../../../../components/loaders/ImageSpinner";


class HQVehicleFilter extends Component {
    constructor(props) {
        super(props);
        this.controller = new HQVehicleFilterController(this);
        this.state = {
            loading: false,
            fields: [],
            vehicles: [],
            locations: [],
            form: {
                pick_up_location: '',
                return_location: '',
                brand_id: '',
                pick_up_time: '',
                return_time: '',
                pick_up_date: '',
                return_date: '',
                //vehicle_class_custom_fields:346,xxx,yyy,zzz
                vehicle_class_custom_fields: [],
                set_default_locations: 'true'
            },
            brands:[],
            spinner: hqSpinner,
        }
    }

    componentDidMount() {
        this.controller.init();
    }
    renderContent(){
        if(this.state.loading){
            return (<ImageSpinner src={this.state.spinner} />);
        }else{
            return(
                <div
                    className="portfolio_filter_wrapper gallery classic three_cols" data-columns={3}>
                    { this.renderVehicles() }
                </div>
            );
        }
    }
    renderVehicles(){
        if(Array.isArray(this.state.vehicles)){
            if(this.state.vehicles.length === 0){
                return (
                    <EmptyListMessage
                        message={"There is no vehicles available that match this criteria."}
                    />
                )
            }else{
                return DisplayValidator.validateArrayAndDisplay(
                    this.state.vehicles,
                    this.state.vehicles.map( (vehicle, index) => <VehicleCard key={index} vehicle={vehicle}/>)
                )
            }
        }else{
            return DisplayValidator.validateArrayAndDisplay(
                this.state.vehicles,
                this.state.vehicles.map( (vehicle, index) => <VehicleCard key={index} vehicle={vehicle}/>)
            )
        }
    }
    renderLocationsOption(){
        return this.state.locations.map((location,index) => <option key={index} value={location.id}>{location.name}</option>);
    }
    renderFilters(){
        return this.state.fields.map( (field, index) => <Select key={index} field={field} onChangeField={this.onChangeField.bind(this)}/> );
    }
    onChangeLocation(event){
        this.controller.onChangeLocation(event.target.value);
    }
    onChangeField(field, newValue){
        this.controller.onChangeField(field, newValue);
    }
    onSubmit(event){
        event.preventDefault();
        this.controller.onSubmitForm();
    }
    render() {

        return (
            <div className="ppb_wrapper">
                <div className="one withsmallpadding ppb_header">
                    <div className="standard_wrapper">
                        <div className="page_content_wrapper">
                            <div className="inner">
                                <div style={{margin: 'auto', width: '100%'}}>
                                    <h2 className="ppb_title">Browse Our Cars</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="one withsmallpadding ppb_car_search">
                    <div className="standard_wrapper">
                        <div className="page_content_wrapper">
                            <div className="inner">
                                <form className="car_search_form" method="get" onSubmit={this.onSubmit.bind(this)}>
                                    <div className="car_search_wrapper">
                                        <div className="one_fourth themeborder">
                                            <select
                                                id="location"
                                                name="location"
                                                onChange={this.onChangeLocation.bind(this)}
                                                value={this.state.form.pick_up_location}
                                            >
                                            {this.renderLocationsOption()}
                                            </select>
                                            <span className="ti-angle-down"/>
                                        </div>
                                        {this.renderFilters()}
                                        <div className="one_fourth last themeborder">
                                            <SubmitButton
                                                onPress={this.onSubmit.bind(this)}
                                                textButton="Search"
                                            />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="ppb_car_classic one nopadding">
                    <div className="page_content_wrapper page_main_content sidebar_content full_width fixed_column">
                        <div className="standard_wrapper">
                            {this.renderContent()}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
export default HQVehicleFilter;