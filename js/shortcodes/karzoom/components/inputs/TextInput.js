import React, { PureComponent } from 'react'

class TextInput extends PureComponent{
    constructor(props){
        super(props);
    }
    renderOptions() {
        return this.props.options.map((option,  index) => <option key={index} value={option.value}>{option[this.props.labelProperty]}</option>);
    }
    /*
    * <input
                    id={this.props.id}
                    name={this.props.name}
                    placeholder={this.props.placeholder}
                    className="hq-inputs-select"
                    onChange={this.props.onChange}
                >
                    {this.renderOptions()}
                </input>*/
    render(){
        return(
            <div>
                <span className="ti-angle-down" />
            </div>

        );
    }
}
export default TextInput;