import React, {Component} from 'react';

class Hidden extends Component{
    constructor(props){
        super(props);
    }
    render(){
        return (
            <input type="hidden" name={this.props.name} value={this.props.value} />
        );
    }
}
export default Hidden;