import React, { PureComponent } from 'react';
import Select from "../components/inputs/Select";
import Map from '../components/maps/Map'
import HQBookingController from "./controllers/HQBookingController";
import SuggestionInput from "../components/inputs/SuggestionInput";
import TextInput from '../components/inputs/TextInput';

class HQBookingForm extends PureComponent{
    constructor(props){
        super(props);
        this.controller = new HQBookingController();
        this.state = {
            suggestionInput: '',
            brands:[],
            locations: [],
            makes: '',
            vehicleClasses: '',
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
    onChangeBrand(event){
        console.log(event.target.value);
    }

    onChangeSuggestionInput(event){
        const {
            target
        } = event;
        this.setState({ suggestionInput: target.value });
        this.controller.onChangeSuggestion(target.value, this);
    }

    //style="padding-top: 150px !important;text-align:center;height:800px;background-image:url(http://themes.themegoods.com/grandcarrental/demo/wp-content/uploads/2017/01/IMG_3496bfree.jpg);background-position: center center;color:#ffffff;"

    //style="color: #fff"
    //style="background:#000000;background:rgb(0,0,0,0.2);background:rgba(0,0,0,0.2);"
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
                                            <div className="one themeborder">
                                                <SuggestionInput
                                                    id="hq-user-location"
                                                    name="user-location"
                                                    placeholder="Your Address"
                                                    suggestions={this.state.suggestions}
                                                    labelProperty="name"
                                                    onChangeInput={this.onChangeSuggestionInput.bind(this)}
                                                    value={this.state.suggestionInput}
                                                />
                                            </div>
                                            <div className="one themeborder">
                                                <Select
                                                    id="hq-brands"
                                                    name="brands"
                                                    placeholder="Select Brands"
                                                    options={this.state.brands}
                                                    labelProperty="name"
                                                    onChange={this.onChangeBrand.bind(this)}
                                                />
                                            </div>
                                            <div className="one themeborder">
                                                <TextInput
                                                    id="test"
                                                    name="test"
                                                    options={[]}
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
                        />
                    </div>
                </div>
            </div>

        );
    }
}
export default HQBookingForm;