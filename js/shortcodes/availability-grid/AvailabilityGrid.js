import React, { PureComponent } from 'react';
import AvailabilityGridController from "../../controllers/AvailabilityGridController";
import VehicleCard from "../../components/cards/VehicleCard";
import DisplayValidator from "../../helpers/render/DisplayValidator";
import DateHelper from "../../helpers/dates/DateHelper";

class AvailabilityGrid extends PureComponent{
    constructor(props) {
        super(props);
        this.state = {
            vehicles: [],
            startDate: DateHelper.nowForSystem(),
            endDate: DateHelper.daysFromNow(1),
            brandId: ''
        };
        this.controller = new AvailabilityGridController(this, this.state.startDate, this.state.endDate, this.state.brandId);
    }
    componentDidMount() {
        this.controller.componentInit( );
    }
    renderVehicles(){
        return DisplayValidator.validateArrayAndDisplay(
            this.state.vehicles,
            this.state.vehicles.map( (vehicle, index) => <VehicleCard key={index} vehicle={vehicle} /> )
            );
    }

    render() {
        return(
            <section className="elementor-element elementor-element-de4707d elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="de4707d" data-element_type="section" id="vehicles" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                <div className="elementor-container elementor-column-gap-default">
                    <div className="elementor-row">
                        <div className="elementor-element elementor-element-73c22157 elementor-column elementor-col-100 elementor-top-column" data-id="73c22157" data-element_type="column">
                            <div className="elementor-column-wrap  elementor-element-populated">
                                <div className="elementor-widget-wrap">
                                    <div className="elementor-element elementor-element-5d8a5dd3 elementor-widget__width-auto elementor-absolute elementor-widget elementor-widget-image" data-id="5d8a5dd3" data-element_type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
                                        <div className="elementor-widget-container">
                                            <div className="elementor-image">
                                                <img width={399} height={372} src="https://smartwheelscuracao.com/wp-content/uploads/2020/04/blob-png.png" className="attachment-large size-large" alt="" srcSet="https://smartwheelscuracao.com/wp-content/uploads/2020/04/blob-png.png 399w, https://smartwheelscuracao.com/wp-content/uploads/2020/04/blob-png-300x280.png 300w" sizes="(max-width: 399px) 100vw, 399px" />											</div>
                                        </div>
                                    </div>
                                    <div className="elementor-element elementor-element-79fe0180 elementor-widget elementor-widget-heading" data-id="79fe0180" data-element_type="widget" data-widget_type="heading.default">
                                        <div className="elementor-widget-container">
                                            <h2 className="elementor-heading-title elementor-size-default">It's time to reinvent wheels</h2>		</div>
                                    </div>
                                    <div className="elementor-element elementor-element-61ac6e7 elementor-widget elementor-widget-shortcode" data-id="61ac6e7" data-element_type="widget" data-widget_type="shortcode.default">
                                        <div className="elementor-widget-container">
                                            <div className="elementor-shortcode">    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossOrigin="anonymous" />
                                                <div className="elementor-element elementor-widget elementor-widget-html" data-id="dc690b3" data-element_type="widget" data-widget_type="html.default">
                                                    <div className="elementor-widget-container">
                                                        {/* Structure */}
                                                        <div className="filter-div">
                                                            <button id="hq-all-vehicles-button" className="filter-button">All wheels</button>
                                                            <button id="hq-cars-button" className="filter-button">Cars</button>
                                                            <button id="hq-bikes-button" className="filter-button">Bikes</button>
                                                            <button id="hq-scooters-button" className="filter-button">Scooters</button>
                                                        </div>
                                                        <div id="hq-smart-vehicle-grid">
                                                            <div id="hq-smart-vehicle-grid-row" className="vehicle-cards-div">
                                                                {this.renderVehicles()}
                                                            </div>
                                                        </div>
                                                        <div className="filter-div">
                                                            <a className="small-cta" id="hq-smart-load-more-button">load more +</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <style dangerouslySetInnerHTML={{__html: "\n        .small-cta{\n            cursor: pointer;\n        }\n        .img-response{\n            min-height: 155px;\n        }\n    " }} />
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
export default AvailabilityGrid;