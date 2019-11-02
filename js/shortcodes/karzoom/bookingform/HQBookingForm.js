import React, { PureComponent } from 'react';
import Select from "../components/inputs/Select";
import Map from '../components/maps/Map'
import HQBookingController from "./controllers/HQBookingController";
import SuggestionInput from "../components/inputs/SuggestionInput";
import TextInput from '../components/inputs/TextInput';
import Hidden from "../components/inputs/Hidden";
import DatesPicker from "../components/inputs/DatesPicker";
import moment from 'moment';
import { APP_DATE_FORMAT } from "../App";

class HQBookingForm extends PureComponent{
    constructor(props){
        super(props);
        this.controller = new HQBookingController();
        this.state = {
            suggestionInput: '',
            brands:[],
            locations: [],
            makes: [],
            vehicleClasses: [],
            errors: '',
            backgroundStyle: {},
            form: {
                brand:'',
                vehicleClass:'',
                make:'',
                pickupDate: '',
                returnDate: '',
                pickupLocation: '',
                returnLocation: ''
            },
            formAction: '',
            mapCenter:{
                //Default Value
                lat: 52.3742108,
                lng: -1.5132913
            },
            suggestions:[]
        };
    }
    componentDidMount(){
        this.controller.componentInit(this);
        this.controller.getLocation( (position) => {
            const { coords } = position;
            const { latitude, longitude } = coords;
            this.setState({
                mapCenter: {
                    lat: latitude,
                    lng: longitude
                }
            });
        },
            // Do Nothing
        );
        const now = moment().format(APP_DATE_FORMAT);
        this.setState({
            form: {
                ...this.state.form,
                pickupDate: now,
                returnDate: now,
            },
            backgroundStyle: {
                backgroundImage: 'url(' + HQMapFormShortcode.backgroundImageURL + ')'
            }
        });
    }
    onChangeSuggestionInput(value){
        this.controller.onChangeSuggestion(value, this);
    }
    onClickOnSuggestion(suggestion){
        this.controller.centerMapOnSuggestionSelection(suggestion, this);
    }
    clearSuggestions(){
        this.setState({ suggestions: [] });
    }
    onSelectLocationOnMap(location){
        this.controller.onSelectLocationOnMap(location, this);
        this.setState({
            formAction: this.resolveActionLink(location),
            form:{
                ...this.state.form,
                pickupLocation: location.id,
                returnLocation: location.id,
                brand: location.brand_id
            }
        });
    }
    resolveActionLink(location){
        const selectedBrand = this.state.brands.filter( brand => String(brand.id) === location.brand_id )[0];
        return selectedBrand.websiteLink;
    }
    onChangePickupDate(date){
        const parseDate = moment(date).format(APP_DATE_FORMAT);
        this.setState({
            form: {
                ...this.state.form,
                pickupDate: parseDate
            }
        });
    }
    onChangeReturnDate(date){
        const parseDate = moment(date).format(APP_DATE_FORMAT);
        this.setState({
            form: {
                ...this.state.form,
                returnDate: parseDate
            }
        });
    }
    onChangeVehicleBrand(event){
        const { value } = event.target;
        this.setState({
            form: {
                ...this.state.form,
                make: value
            }
        });
        this.controller.onChangeVehicleBrand(value, this);
    }
    onChangeVehicleClass(event){
        const { value } = event.target;
        this.setState({
            form: {
                ...this.state.form,
                vehicleClass: value
            }
        });
    }
    onChangeBranch(event){
        const { value } = event.target;
        this.setState({
            formAction: this.resolveActionLinkWithBrandID(value),
            form:{
                ...this.state.form,
                pickupLocation: this.resolveLocationIdOnBrands(value),
                returnLocation: this.resolveLocationIdOnBrands(value),
                brand: value
            }
        });
    }
    resolveActionLinkWithBrandID(id){
        const selectedBrand = this.state.brands.find( brand => String(brand.id) === String(id) );
        return selectedBrand.websiteLink;
    }
    resolveLocationIdOnBrands(brandId){
        const selectedBrand = this.state.brands.find( brand => String(brand.id) === String(brandId) );
        const selectedLocation = selectedBrand.locations[0];
        return selectedLocation.id;
    }
    render(){
        return(
            <div className="one" id="hq-map-shortcode" style={this.state.backgroundStyle}>
                <div className="one_half">
                    <div className="withsmallpadding ppb_car_search_background parallax withbg">
                        <div className="overlay_background" />
                        <div className="center_wrapper">
                            <div className="inner_content">
                                <div className="standard_wrapper">
                                    <h2 className="ppb_title hq-shortcode-map-title">{"Car Hire Where You Need It!"}</h2>
                                    <div className="page_tagline hq-shortcode-map-subtitle">{"From as low as $10 per day with limited\n" +
                                    "                                time offer discounts"}</div>
                                    <form className="car_search_form" method="POST" action={this.state.formAction} >
                                        <div className="car_search_wrapper">
                                            <div className="one themeborder hq-input-wrapper">
                                                <SuggestionInput
                                                    id="hq-user-location"
                                                    placeholder="Your Address"
                                                    suggestions={this.state.suggestions}
                                                    labelProperty="name"
                                                    onChangeInput={this.onChangeSuggestionInput.bind(this)}
                                                    value={this.state.suggestionInput}
                                                    onClickSuggestion={this.onClickOnSuggestion.bind(this)}
                                                    clearSuggestions={this.clearSuggestions.bind(this)}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <Select
                                                    placeholder="Select Pick-up Location"
                                                    options={this.state.brands}
                                                    branches={true}
                                                    onChange={this.onChangeBranch.bind(this)}
                                                    value={this.state.form.brand}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <Select
                                                    placeholder="Brands"
                                                    options={this.state.makes}
                                                    makes={true}
                                                    onChange={this.onChangeVehicleBrand.bind(this)}
                                                    value={this.state.form.make}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <Select
                                                    placeholder="Vehicle Classes"
                                                    options={this.state.vehicleClasses}
                                                    vehicleClass={true}
                                                    onChange={this.onChangeVehicleClass.bind(this)}
                                                    value={this.state.form.vehicleClass}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <DatesPicker
                                                    placeholder="Pickup Date"
                                                    onChange={this.onChangePickupDate.bind(this)}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <DatesPicker
                                                    placeholder="Return Date"
                                                    onChange={this.onChangeReturnDate.bind(this)}
                                                />
                                            </div>
                                            <div className="one_fourth last themeborder">
                                                <Hidden
                                                    name="pick_up_location"
                                                    value={this.state.form.pickupLocation}
                                                />
                                                <Hidden
                                                    name="return_location"
                                                    value={this.state.form.returnLocation}
                                                />
                                                <Hidden
                                                    name="pick_up_date"
                                                    value={this.state.form.pickupDate}
                                                />
                                                <Hidden
                                                    name="return_date"
                                                    value={this.state.form.returnDate}
                                                />
                                                <input id="car_search_btn" type="submit" className="button" value="Search" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="one_half map-wrapper">
                    <div className="hq-map-wrapper">
                        <Map
                            zoom={15}
                            initialCenter={this.state.mapCenter}
                            mapCenter={this.state.mapCenter}
                            locations={this.state.locations}
                            onPressMarker={this.onSelectLocationOnMap.bind(this)}
                        />
                    </div>
                </div>
            </div>

        );
    }
}
export default HQBookingForm;