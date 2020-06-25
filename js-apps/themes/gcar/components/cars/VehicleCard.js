import React, {Component} from 'react';


class VehicleCard extends Component {
    constructor() {
        super();
    }

    render() {
        return (
            <div id={"hq-vehicle-class-" + this.props.vehicle.id} className="element grid classic4_cols animated1">
                <div
                    className="one_fourth gallery4 classic static filterable portfolio_type themeborder">
                    <a className="car_image" href={this.props.vehicle.permalink}>
                        <img
                            src={this.props.vehicle.publicImageLink}
                            alt={this.props.vehicle.name}
                        />
                    </a>
                    <div className="portfolio_info_wrapper">
                        <div className="car_attribute_wrapper">
                            <a className="car_link" href={this.props.vehicle.permalink}>
                                <h5>
                                    {this.props.vehicle.name}
                                </h5>
                            </a>
                            <div className="car_attribute_rating">
                                <div className="br-theme-fontawesome-stars-o">
                                    <div className="br-widget"></div>
                                </div>
                                <div className="car_attribute_rating_count">4&nbsp;reviews</div>
                            </div>
                            <div className="car_attribute_wrapper_icon">
                                <div className="one_fourth">
                                    <div className="car_attribute_icon ti-briefcase"/>
                                    <div className="car_attribute_content">2
                                    </div>
                                </div>
                                <div className="one_fourth">
                                    <div className="car_attribute_icon ti-panel"/>
                                    <div className="car_attribute_content">Auto
                                    </div>
                                </div>
                            </div>
                            <br className="clear"/></div>
                        <div className="car_attribute_price">
                            <div className="car_attribute_price_day four_cols">
                                <span
                                    className="single_car_price">{this.props.vehicle.rate.dailyRateAmountForDisplay}</span>
                                <span className="car_unit_day">Per Day</span>
                            </div>
                        </div>
                        <br className="clear"/>
                    </div>
                </div>
            </div>
        );
    }
}

export default VehicleCard;