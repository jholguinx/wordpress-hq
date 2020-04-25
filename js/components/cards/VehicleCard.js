import React, {PureComponent} from 'react';

class VehicleCard extends PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="vehicle-card hover-y">
                {/* Single Card */}
                <img className="img-response"
                     src="https://files.miami.hqrentals.app/tenants/28c1919d-7400-4b39-a60d-879f62e4920b/files/693d6613-fe53-413b-9711-7d9a05a697ee/redirect/1587431615/timestamp?size=500"/>
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
        );
    }
}

export default VehicleCard;