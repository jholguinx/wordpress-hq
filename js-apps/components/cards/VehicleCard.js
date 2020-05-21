import React, {PureComponent} from 'react';
import {Col} from "rsuite";
import DisplayValidator from "../../helpers/render/DisplayValidator";

class VehicleCard extends PureComponent {
    constructor(props) {
        super(props);
    }
    renderFeatures(){
        return DisplayValidator.validateArrayAndDisplay(
            this.props.vehicle.vehicle_class.features,
            this.props.vehicle.vehicle_class.features.map( (feature, index) =>
                <li key={index}>
                    <span><i aria-hidden="true" className={feature.icon} /> </span>
                <span>{feature.label}</span>
                </li>
            ));
    }
    renderRate(){
        if(this.props.vehicle.vehicle_class.rate.amount_for_display){
            return <p><span>{this.props.vehicle.vehicle_class.rate.amount_for_display}&nbsp;</span> / Day</p>;
        }else{
            return <p/>;
        }
    }
    render() {
        const {
            id,
            name,
            public_image_link
        } = this.props.vehicle.vehicle_class;
        return (
            <FlexboxGrid.Item
                xs={24}
                sm={24}
                md={8}
                lg={8}
            >
                <div className="vehicle-card hover-y">
                    {/* Single Card */}
                    <img className="img-response"
                         src={public_image_link}/>
                    <h3>{name}</h3>
                    <ul className="no-bulls">
                        {this.renderFeatures()}
                    </ul>
                    <div className="bottom-info">
                        {this.renderRate()}
                        <a className="small-cta" href={this.props.vehicle.vehicle_class.brand.websiteLink + '?vehicle_class_id=' + id}>Rent Now</a>
                    </div>
                    {/* End Single Card */}
                </div>
            </FlexboxGrid.Item>
        );
    }
}

export default VehicleCard;