import React, { PureComponent } from 'react'

class Select extends PureComponent{
    constructor(props){
        super(props);
    }
    renderOptions() {
        return this.props.options.map((option,  index) => <option key={index} value={option.value}>{option[this.props.labelProperty]}</option>);
    }
    render(){
        return(
            <div>
                <select id={this.props.id} name={this.props.name} placeholder={this.props.placeholder} className="hq-inputs-select">
                    {this.renderOptions()}
                </select>
                <span className="ti-angle-down" />
            </div>

        );
    }
}
export default Select;