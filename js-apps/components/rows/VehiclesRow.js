import React, { PureComponent } from 'react';
import {Col, Grid, Row} from "rsuite";
import VehicleCard from "../cards/VehicleCard";
import DisplayValidator from "../../helpers/render/DisplayValidator";
import PropTypes from 'prop-types';

class VehiclesRow extends PureComponent{
    constructor(props){
        super(props);
    }
    renderVehicle(){
        return DisplayValidator.validateArrayAndDisplay(
            this.props.vehicles,
            this.props.vehicles.map( (vehicle, index) => <VehicleCard key={index} vehicle={vehicle} baseURL={this.props.baseURL} lenght={this.props.vehicles.length} /> )
        );
    }
    render() {
        return(
            <Grid fluid>
                <Row className="show-grid hq-availability-row-wrapper">
                    {this.renderVehicle()}
                </Row>
            </Grid>

        );
    }
}
VehiclesRow.propTypes = {
    vehicles: PropTypes.array
};
export default VehiclesRow;