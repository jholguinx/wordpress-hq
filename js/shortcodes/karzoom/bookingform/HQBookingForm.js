import React, { PureComponent } from 'react';
import Select from "../components/inputs/Select";
import Map from '../components/maps/Map'
import HQBookingController from "./controllers/HQBookingController";
import SuggestionInput from "../components/inputs/SuggestionInput";
import TextInput from '../components/inputs/TextInput';
import DatesPicker from "../components/inputs/DatesPicker";

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
            form: {
                brand:{},
                vehicleClass:{},
                make:{},
                pickupDate: '',
                returnDate: ''
            },
            mapCenter:{
                lat: 10.4984684,
                lng: -66.7956924
            },
            suggestions:[]
        }
    }
    componentDidMount(){
        this.controller.componentInit(this);
        this.controller.getLocation( (location) => {
            console.log(location);
        },
            () => console.log('error')

        );
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
    }
    onChangePickupDate(date){
        this.setState({
            form: {
                ...this.state.form,
                pickupDate: date,
            }
<<<<<<< HEAD
        });
=======
        })
>>>>>>> karzoom
    }
    onChangeReturnDate(date){
        this.setState({
            form: {
                ...this.state.form,
                returnDate: date,
            }
        })
    }
    render(){
        return(
            <div className="one">
                <div className="one_half">
                    <div className="withsmallpadding ppb_car_search_background parallax withbg">
                        <div className="overlay_background" />
                        <div className="center_wrapper">
                            <div className="inner_content">
                                <div className="standard_wrapper">
                                    <h2 className="ppb_title">{"Find Best Car &amp; Limousine"}</h2>
                                    <div className="page_tagline">{"From as low as $10 per day with limited\n" +
                                    "                                time offer discounts"}</div>
                                    <form className="car_search_form" method="get" >
                                        <div className="car_search_wrapper">
                                            <div className="one themeborder hq-input-wrapper">
                                                <SuggestionInput
                                                    id="hq-user-location"
                                                    name="user-location"
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
                                                    placeholder="Brands"
                                                    options={this.state.makes}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <Select
                                                    placeholder="Vehicle Classes"
                                                    options={this.state.vehicleClasses}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <DatesPicker
                                                    placeholder="Vehicle Classes"
                                                    onChange={this.onChangePickupDate.bind(this)}
                                                />
                                            </div>
                                            <div className="one themeborder hq-input-wrapper">
                                                <DatesPicker
                                                    placeholder="Vehicle Classes"
                                                    onChange={this.onChangeReturnDate.bind(this)}
                                                />
                                            </div>
                                            <div className="one_fourth last themeborder">
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