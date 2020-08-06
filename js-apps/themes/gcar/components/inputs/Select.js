import React, {Component} from 'react';

class Select extends Component {
    constructor(props) {
        super(props);
    }
    renderOptions(){
        return Object.entries(this.props.field.options).map((option,index) => <option key={index} value={option[0]}>{option[1]}</option>);
    }
    onChange(event){
        this.props.onChangeField(this.props.field, event.target.value);
    }
    render() {
        return (
            <div className="one_fourth themeborder">
                <select name="sort_by" onChange={this.onChange.bind(this)}>
                    {this.renderOptions()}
                </select>
                <span className="ti-angle-down"/>
            </div>
        );
    }
}

export default Select;