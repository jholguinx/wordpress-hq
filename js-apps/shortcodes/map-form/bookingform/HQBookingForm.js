import React, { PureComponent } from 'react';
import Select from "../components/inputs/Select";
import Map from '../components/maps/Map';
import HQBookingController from "./controllers/HQBookingController";
import SuggestionInput from "../components/inputs/SuggestionInput";
import Hidden from "../components/inputs/Hidden";
import DatePicker from "../components/inputs/DatePicker";
import moment from 'moment';
import { APP_DATE_ONLY_FORMAT } from "../App";
class HQBookingForm extends PureComponent{
    constructor(props){
        super(props);
        this.controller = new HQBookingController();
        this.state = {
            x : 5, // time interval
            suggestionInput: '',
            brands:[],
            locations: [],
            makes: [],
            vehicleClasses: [],
            errors: '',
            backgroundStyle: {},
            pickupTimeOptions: [],
            returnTimeOptions: [],
            form: {
                brand:'',
                vehicleClass:'',
                make:'',
                pickupDate: '',
                returnDate: '',
                pickupTime: '',
                returnTime: '',
                pickupLocation: '',
                returnLocation: ''
            },
            formAction: '',
            mapCenter: {
                //Default Value
                lat: (HQMapFormShortcode.defaultLatitude) ? parseFloat(HQMapFormShortcode.defaultLatitude) : 53,
                lng: (HQMapFormShortcode.defaultLongitude) ? parseFloat(HQMapFormShortcode.defaultLongitude) : -2
            },
            suggestions:[],
            selectedLocationOnMap: '',
            enabledLocationTracking: false
        };
    }
    componentWillMount(){
        this.controller.componentInit(this);
        const image = (HQMapFormShortcode.backgroundImageURL) ? HQMapFormShortcode.backgroundImageURL : "";
        this.setState({
            form: {
                ...this.state.form,
                pickupDate: moment().add(2,'days').format(APP_DATE_ONLY_FORMAT),
                returnDate: moment().add(9,'days').format(APP_DATE_ONLY_FORMAT)
            },
            backgroundStyle: {
                backgroundImage: 'url(' + image + ')'
            },
            pickupTimeOptions: this.getTimeOptions(480, 18),
            returnTimeOptions: this.getTimeOptions(480, 18)
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
    getTimeOptions(startTime, endTimeHour){
        //loop to increment the time and push results in array
        let times = [];
        let x = 30; //minutes interval
        let tt = startTime; // start time
        let ap = ['am', 'pm']; // AM-PM
        for (var i=0; tt<= endTimeHour*60; i++) {
            var hh = Math.floor(tt/60); // getting hours of day in 0-24 format
            var mm = (tt%60); // getting minutes of the hour in 0-55 format
            times[i] = ((hh % 12 === 0) ? "12" : ("0" + (hh % 12)).slice(-2)) + ':' + ("0" + mm).slice(-2) + ap[Math.floor(hh/12)]; // pushing data in array in [00:00 - 12:00 AM/PM format]
            tt = tt + x;
        }
        return times;
    }
    onSelectLocationOnMap(location){
        if(String(location.id) !== this.state.selectedLocationOnMap){
            this.controller.onSelectLocationOnMap(location, this);
            this.setState({
                formAction: this.resolveActionLink(location),
                form:{
                    ...this.state.form,
                    pickupLocation: location.id,
                    returnLocation: location.id,
                    brand: location.brand_id,
                    make: "",
                    vehicleClass:'',
                },
                selectedLocationOnMap: location.id
            });
        }
    }
    resolveActionLink(location){
        const selectedBrand = this.state.brands.filter( brand => String(brand.id) === location.brand_id )[0];
        return selectedBrand.websiteLink;
    }
    onChangePickupDate(date){
        const data = moment(date);
        let newTimes = this.getTimeOptions(480, 18);
        if(data.day() === 0){
            newTimes = this.getTimeOptions(600, 16);
        }
        if(data.day() === 6){
            newTimes = this.getTimeOptions(540, 17);
        }
        this.setState({
            form: {
                ...this.state.form,
                pickupDate: data.format(APP_DATE_ONLY_FORMAT),
                returnDate: data.add(7, 'days').format(APP_DATE_ONLY_FORMAT)
            },
            pickupTimeOptions: newTimes
        });

    }
    onChangeReturnDate(date){
        const data = moment(date);
        let newTimes = this.getTimeOptions(480, 18);
        if(data.day() === 0){
            newTimes = this.getTimeOptions(600, 16);
        }
        if(data.day() === 6){
            newTimes = this.getTimeOptions(540, 17);
        }
        this.setState({
            form: {
                ...this.state.form,
                returnDate: data.format(APP_DATE_ONLY_FORMAT),
            },
            returnTimeOptions: newTimes
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
                brand: value,
                make: "",
                vehicleClass:'',
                pick_up_time: '',
                return_time: ''
            }
        });
        const location = this.getLocationFromBrandId(value);
        this.setState({
            mapCenter: location.coordinates,
            selectedLocationOnMap: location.id
        });
        this.controller.onSelectLocationOnMap(value, this, true);
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
    getLocationFromBrandId(brandId){
        return this.state.locations.find( location => String(location.brand_id) === String(brandId) );
    }
    onSubmit(){

    }
    onChangePickupTime(event){
        const { value } = event.target;
        this.setState({
            form: {
                ...this.state.form,
                pickupTime: value,
                returnTime: value
            }
        });
    }
    onChangeReturnTime(event){
        const { value } = event.target;
        this.setState({
            form: {
                ...this.state.form,
                returnTime: value
            }
        });
    }
    render(){
        return(
            <div className="one" id="hq-map-shortcode" >
                <div id="hq-map-image-background-placeholder" style={this.state.backgroundStyle}></div>
                <div className="hq-form-inner-wrapper">
                    <div className="one_half hq-form-column-wrapper">
                        <div className="withsmallpadding ppb_car_search_background parallax withbg">
                            <div className="overlay_background" />
                            <div className="center_wrapper">
                                <div className="inner_content">
                                    <div className="standard_wrapper">
                                        <h2 className="ppb_title hq-shortcode-map-title">{"Car Hire Where You Need It!"}</h2>
                                        <form className="car_search_form" method="POST" action={this.state.formAction} onSubmit={this.onSubmit.bind(this)}>
                                            <div className="car_search_wrapper">
                                                <div className="one themeborder hq-input-wrapper">
                                                    <SuggestionInput
                                                        id="hq-user-location"
                                                        placeholder="Enter Town, City or Postcode"
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
                                                        placeholder="Any Brands"
                                                        options={this.state.makes}
                                                        makes={true}
                                                        onChange={this.onChangeVehicleBrand.bind(this)}
                                                        value={this.state.form.make}
                                                    />
                                                </div>
                                                <div className="one themeborder hq-input-wrapper">
                                                    <Select
                                                        placeholder="Any Vehicle Classes"
                                                        options={this.state.vehicleClasses}
                                                        vehicleClass={true}
                                                        onChange={this.onChangeVehicleClass.bind(this)}
                                                        value={this.state.form.vehicleClass}
                                                    />
                                                </div>
                                                <div className="one themeborder hq-input-wrapper hq-dates-wrapper">
                                                    <div className="hq-dates-inner-wrapper">
                                                        <DatePicker
                                                            placeholder="Pickup Date"
                                                            pickup={true}
                                                            onChange={this.onChangePickupDate.bind(this)}
                                                            value={this.state.form.pickupDate}
                                                        />
                                                    </div>
                                                    <div className="hq-dates-inner-wrapper">
                                                        <Select
                                                            placeholder="Pickup Time"
                                                            options={this.state.pickupTimeOptions}
                                                            makes={true}
                                                            onChange={this.onChangePickupTime.bind(this)}
                                                            value={this.state.form.pickupTime}
                                                            labelProperty="time"
                                                            time={true}
                                                        />
                                                    </div>
                                                </div>
                                                <div className="one themeborder hq-input-wrapper hq-dates-wrapper">
                                                    <div className="hq-dates-inner-wrapper">
                                                        <DatePicker
                                                            placeholder="Return Date"
                                                            pickup={false}
                                                            onChange={this.onChangeReturnDate.bind(this)}
                                                            value={this.state.form.returnDate}
                                                        />
                                                    </div>
                                                    <div className="hq-dates-inner-wrapper">
                                                        <Select
                                                            placeholder="Return Time"
                                                            options={this.state.returnTimeOptions}
                                                            makes={true}
                                                            onChange={this.onChangeReturnTime.bind(this)}
                                                            value={this.state.form.returnTime}
                                                        />
                                                    </div>
                                                </div>
                                                <div id="hq-hidden-fields-wrapper" className="one_fourth last themeborder">
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
                                                        name="pick_up_time"
                                                        value={this.state.form.pickupTime}
                                                    />
                                                    <Hidden
                                                        name="return_date"
                                                        value={this.state.form.returnDate}
                                                    />
                                                    <Hidden
                                                        name="return_time"
                                                        value={this.state.form.returnTime}
                                                    />
                                                    <Hidden
                                                        name="vehicle_class_id"
                                                        value={this.state.form.vehicleClass}
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
                    <div className="one_half map-wrapper hq-map-column-wrapper">
                        <div className="hq-map-wrapper">
                            <Map
                                zoom={13}
                                initialCenter={this.state.mapCenter}
                                mapCenter={this.state.mapCenter}
                                locations={this.state.locations}
                                onPressMarker={this.onSelectLocationOnMap.bind(this)}
                            />
                        </div>
                    </div>
                </div>
            </div>

        );
    }
}
export default HQBookingForm;
