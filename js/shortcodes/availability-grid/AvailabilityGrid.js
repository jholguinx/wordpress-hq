import React, { PureComponent } from 'react';
import AvailabilityGridController from "../../controllers/AvailabilityGridController";
import VehicleCard from "../../components/cards/VehicleCard";
import DisplayValidator from "../../helpers/render/DisplayValidator";
import DateHelper from "../../helpers/dates/DateHelper";
import DateRangePicker from "../../components/datepickers/DateRangePicker";
import Loader from '../../components/loaders/Loader';
import { Grid, Row, Col } from 'rsuite';
import PropTypes from 'prop-types';
import VehiclesRow from '../../components/rows/VehiclesRow';
class AvailabilityGrid extends PureComponent{
    constructor(props) {
        super(props);
        this.state = {
            vehiclesPerRow: [],
            startDate: DateHelper.nowForSystem(),
            endDate: DateHelper.daysFromNow(1),
            brandId: '',
            dateRange: [DateHelper.nowDate(), DateHelper.daysFromNowDate(1)],
            isLoading: false
        };
        this.controller = new AvailabilityGridController(this);
    }
    componentDidMount() {
        this.controller.componentRefreshData( );
    }
    renderVehicles(){
        return DisplayValidator.validateArrayAndDisplay(
            this.state.vehiclesPerRow,
            this.state.vehiclesPerRow.map( (vehicleRow, index) => <VehiclesRow key={index} vehicles={vehicleRow} /> )
            );
    }
    onChangeDates( dateRangeValues ){
        this.controller.onChangeDates( dateRangeValues );
    }
    renderVehiclesContent(){
        if(this.state.isLoading){
            return(<Loader />);
        }else{
            return(
                <div id="hq-smart-vehicle-grid">
                    <div id="hq-smart-vehicle-grid-row" className="vehicle-cards-div">
                        {this.renderVehicles()}
                    </div>
                </div>
            );
        }
    }
    render() {
        return(
            <section className="vehicle-availability-wrapper">
                <div className="elementor-container elementor-column-gap-default">
                    <div className="elementor-row">
                        <div className="elementor-element elementor-element-73c22157 elementor-column elementor-col-100 elementor-top-column" data-id="73c22157" data-element_type="column">
                            <div className="elementor-column-wrap  elementor-element-populated">
                                <div className="elementor-widget-wrap">
                                    <div className="elementor-element elementor-element-79fe0180 elementor-widget elementor-widget-heading" data-id="79fe0180" data-element_type="widget" data-widget_type="heading.default">
                                        <div className="elementor-widget-container">
                                            <h2 className="elementor-heading-title elementor-size-default">It's time to reinvent wheels</h2>		</div>
                                    </div>
                                    <Grid fluid>
                                        <Row className="show-grid">
                                            <Col md={6} mdOffset={18}>
                                                <DateRangePicker
                                                    onChange={this.onChangeDates.bind(this)}
                                                    value={this.state.dateRange}
                                                />
                                            </Col>
                                        </Row>
                                    </Grid>

                                    <div className="elementor-element elementor-element-61ac6e7 elementor-widget elementor-widget-shortcode" data-id="61ac6e7" data-element_type="widget" data-widget_type="shortcode.default">
                                        <div className="elementor-widget-container">
                                            <div className="elementor-shortcode">
                                                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossOrigin="anonymous" />
                                                <div className="elementor-element elementor-widget elementor-widget-html" data-id="dc690b3" data-element_type="widget" data-widget_type="html.default">
                                                    <div className="elementor-widget-container">
                                                        {this.renderVehiclesContent()}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

AvailabilityGrid.propTypes = {
    vehicles: PropTypes.array
};
export default AvailabilityGrid;