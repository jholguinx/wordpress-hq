import React , { Component } from 'react';
import { DateTimePicker } from 'react-widgets';

const styles = require('../../../../../node_modules/react-widgets/dist/css/react-widgets.css');

//https://jquense.github.io/react-widgets/api/DateTimePicker/
class DatesPicker extends Component{
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <DateTimePicker
                onChange={this.props.onChange}
                defaultValue={new Date()}
            />
        );
    }
}
export default DatesPicker;