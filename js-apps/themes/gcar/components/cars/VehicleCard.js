import React, {Component} from 'react';
import ArrayHelper from "../../../../helpers/generic/ArrayHelper";


class VehicleCard extends Component {
    constructor(props) {
        super(props);
    }
    renderFeatures(){
        return ArrayHelper.splice(this.props.vehicle.features, 2).map( ( feature, index ) => {
            return(
                <div key={index} className="one_fourth feature-wrapper">
                    <i className={feature.icon} />
                    <div className="car_attribute_content">{feature.label}
                    </div>
                </div>
            );
        })
    }
    renderPrice(){
        if(this.props.vehicle.rate.base_monthly_price.amount){
            return(
                <div className="car_attribute_price">
                    <div className="car_attribute_price_day four_cols">
                                <span className="single_car_currency">R</span>
                                <span
                                    className="single_car_price">{Number.parseFloat(this.props.vehicle.rate.base_monthly_price.amount).toFixed(0)}</span>
                        <span className="car_unit_day">Per Month</span>
                    </div>
                </div>
            );
        }
    }
    render() {
        return (
            <div id={"hq-vehicle-class-" + this.props.vehicle.id} className="element grid classic4_cols animated1">
                <div
                    className="one_fourth gallery4 classic static filterable portfolio_type themeborder">
                    <a className="car_image" href={this.props.vehicle.permalink}>
                        <img
                            src={this.props.vehicle.image}
                            alt={this.props.vehicle.label}
                        />
                    </a>
                    <div className="portfolio_info_wrapper">
                        <div className="car_attribute_wrapper">
                            <a className="car_link" href={this.props.vehicle.permalink}>
                                <h5>
                                    {this.props.vehicle.label}
                                </h5>
                            </a>
                            <div className="car_attribute_wrapper_icon">
                                {this.renderFeatures()}

                            </div>
                            <br className="clear"/></div>
                        {this.renderPrice()}
                        <br className="clear"/>
                    </div>
                </div>
            </div>
        );
    }
}

export default VehicleCard;