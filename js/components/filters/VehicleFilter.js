import React, {PureComponent} from 'react';

class VehicleFilter extends PureComponent {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <div className="filter-div">
                {/* Structure */}
                <button id="hq-all-vehicles-button" className="filter-button">All wheels</button>
                <button id="hq-cars-button" className="filter-button">Cars</button>
                <button id="hq-bikes-button" className="filter-button">Bikes</button>
                <button id="hq-scooters-button" className="filter-button">Scooters</button>
            </div>
        );
    }
}
export default VehicleFilter;