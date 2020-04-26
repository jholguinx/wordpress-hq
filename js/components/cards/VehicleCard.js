import React, {PureComponent} from 'react';
import {Col} from "rsuite";

class VehicleCard extends PureComponent {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <Col
                xs={24}
                sm={24}
                md={8}
                lg={8}
            >
                <div className="vehicle-card hover-y">
                    {/* Single Card */}
                    <img className="img-response"
                         src={this.props.vehicle.vehicle_class.public_image_link}/>
                    <h3>Kia Picanto - Automatic</h3>
                    <ul className="no-bulls">
                        <li>
                            <span><i aria-hidden="true" className="far fa-snowflake"/> </span>
                            <span>Airconditioning</span>
                        </li>
                        <li>
                            <span><i aria-hidden="true" className="fas fa-broadcast-tower"/> </span>
                            <span>Radio/CD Player</span>
                        </li>
                        <li>
                            <span><i aria-hidden="true" className="fas fa-cog"/> </span>
                            <span>Automatic Transmission</span>
                        </li>
                    </ul>
                    <div className="bottom-info">
                        <p><span>$40.00&nbsp;</span> / Day</p>
                        <a className="small-cta" href="/cars-reservations/?vehicle_class_id=1">rent now</a>
                    </div>
                    {/* End Single Card */}
                </div>
            </Col>
        );
    }
}

export default VehicleCard;