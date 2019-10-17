import React, { PureComponent } from 'react';
import Select from "../components/inputs/Select";
import TextInput from '../components/inputs/TextInput';
import Map from '../components/maps/Map'
import HQBookingController from "./controllers/HQBookingController";

class HQBookingForm extends PureComponent{
    constructor(props){
        super(props);
        this.controller = new HQBookingController();
        this.state = {
            suggestionInput: '',
            brands:[],
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
                lat: 52.2550356,
                lng: -1.3115472
            }
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

    OnChangeMapSuggestions(){

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
                            defaultZoom={8}
                            zoom={8}
                            defaultCenter={this.state.mapCenter}
                            mapCenter={this.state.mapCenter}
                        />
                    </div>
                </div>
            </div>

        );
    }
}
export default HQBookingForm;