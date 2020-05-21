import React, {PureComponent} from 'react';
import DisplayValidator from "../../helpers/render/DisplayValidator";

class VehicleFilter extends PureComponent {
    constructor(props) {
        super(props);
    }
    onClickBrand(brand){
        this.props.onPressBrandItem(brand);
    }
    onPressAllButton(){
        this.props.onPressBrandItem({ id: '' });
    }
    renderBrands(){
        return DisplayValidator.validateArrayAndDisplay(
            this.props.brands,
            this.props.brands.map( (brand, index) => <button key={index} className="filter-button" onClick={this.onClickBrand.bind(this, brand)}>{brand.name}</button> )

        );
    }
    render() {
        return (
            <div className="filter-div hq-availability-filter-wrapper">
                {/* Structure */}
                <button id="hq-all-vehicles-button" className="filter-button" onClick={this.onPressAllButton.bind(this)}>All</button>
                {this.renderBrands()}
            </div>
        );
    }
}
export default VehicleFilter;