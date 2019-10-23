import React, { PureComponent } from 'react'

class Select extends PureComponent{
    constructor(props){
        super(props);
    }
    renderOptions() {
        if(this.props.vehicleClass){
            return this.props.options.map((option,  index) => <option key={index} value={option.id}>{option.name}</option>);
        }else if(this.props.makes){
            return this.props.options.map((option,  index) => <option key={index} value={option}>{option}</option>);
        }else{
            return this.props.options.map((option,  index) => <option key={index} value={option.value}>{option[this.props.labelProperty]}</option>);
        }

    }
    render(){
        return(
            <div>
                <select
                    id={this.props.id}
                    name={this.props.name}
                    placeholder={this.props.placeholder}
                    className="hq-inputs-select"
                    onChange={this.props.onChange}
                >
                    {this.renderOptions()}
                </select>
            </div>

        );
    }
}
export default Select;