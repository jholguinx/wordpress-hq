import React, {Component} from 'react';

class Select extends Component {
    constructor(props) {
        super(props);
    }
    renderOptions(){
        return Object.entries(this.props.field.options).map((option,index) => {
            if(option[0]){
                return <option key={index} value={option[0]}>{option[1]}</option>;
            }
        });
    }
    render() {
        return (
            <div className="one_fourth themeborder">
                <select name="sort_by" onChange={this.onChange}>
                    {this.renderOptions()}
                </select>
                <span className="ti-exchange-vertical"/>
            </div>
        );
    }
}

export default Select;