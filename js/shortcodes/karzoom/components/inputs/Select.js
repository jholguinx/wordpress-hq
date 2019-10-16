import React, { PureComponent } from 'react'

class Select extends PureComponent{
    constructor(props){
        super(props);
    }
    renderOptions() {
        return this.props.options.map(option => <option value={option.value}>{option.label}</option>);
    }
    render(){
        return(
            <div>
                <select id={this.props.id} name={this.props.name}>
                    {this.renderOptions()}
                </select>
                <span className="ti-angle-down" />
            </div>

        );
    }
}
export default Select;