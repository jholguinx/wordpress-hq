import React, {Component} from 'react';
import HQVehicleFilterController from "../../controllers/HQVehicleFilterController";
import Loader from '../../../../components/loaders/Loader';
import DisplayValidator from "../../../../helpers/render/DisplayValidator";
import VehicleCard from "../../components/cars/VehicleCard";
import Select from "../../components/inputs/Select";
import SubmitButton from '../../components/buttons/SubmitButton'
import EmptyListMessage from "../../components/messages/EmptyListMessage";


class HQVehicleFilter extends Component {
    constructor(props) {
        super(props);
        this.controller = new HQVehicleFilterController(this);
        this.state = {
            loading: false,
            fields: [],
            vehicles: [],
            form: {
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
        }
    }

    componentDidMount() {
        this.controller.init();
    }

    onPressSubmit() {
        this.controller.onPressSubmit();
    }
    renderContent(){
        if(this.state.loading){
            return (<Loader />);
        }else{
            return(
                <div
                    className="portfolio_filter_wrapper gallery classic four_cols" data-columns={4}>
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
    renderBrandsOption(){
        return this.state.brands.map((brand,index) => <option key={index} value={brand.id}>{brand.name}</option>);
    }
    renderFilters(){
        return this.state.fields.map( (field, index) => <Select key={index} field={field} onChangeField={this.onChangeField.bind(this)}/> );
    }
    onChangeBrand(event){
        this.controller.onChangeBrand(event.target.value);
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
                                                id="brand"
                                                name="brand"
                                                onChange={this.onChangeBrand.bind(this)}
                                                value={this.state.form.brand_id}
                                            >
                                            {this.renderBrandsOption()}
                                            </select>
                                            <span className="ti-angle-down"/>
                                        </div>
                                        {this.renderFilters()}
                                        <div className="one_fourth last themeborder">
                                            <SubmitButton
                                                onPress={this.onSubmit.bind(this)}
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