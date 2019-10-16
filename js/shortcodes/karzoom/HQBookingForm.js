import React, { PureComponent } from 'react';
import Select from "./components/inputs/Select";
import Map from './components/maps/Map'
class HQBookingForm extends PureComponent{
    constructor(props){
        super(props);
    }
    componentDidMount(){

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
                                    <form className="car_search_form" method="get"
                                          action="http://themes.themegoods.com/grandcarrental/demo/car-list-right-sidebar/">
                                        <div className="car_search_wrapper">
                                            <div className="one_fourth themeborder">
                                                <Select
                                                    id="test"
                                                    name="test"
                                                    options={[]}
                                                />
                                            </div>
                                            <div className="one_fourth themeborder">
                                                <Select
                                                    id="test"
                                                    name="test"
                                                    options={[]}
                                                />
                                            </div>
                                            <div className="one_fourth themeborder">
                                                <Select
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
                <div className="one_half">

                    <Map
                        defaultZoom={8}
                        defaultCenter={{ lat: -34.397, lng: 150.644 }}
                    />
                </div>
            </div>

        );
    }
}
export default HQBookingForm;