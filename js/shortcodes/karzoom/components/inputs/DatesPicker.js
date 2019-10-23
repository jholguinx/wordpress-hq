import React , { Component } from 'react';
import { DateTimePicker } from 'react-widgets';
import moment from 'moment';
const styles = require('../../../../../node_modules/react-widgets/dist/css/react-widgets.css');
import { APP_DATE_FORMAT, APP_TIME_FORMAT } from "../../App";

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
                format={APP_DATE_FORMAT}
                timeFormat={APP_TIME_FORMAT}
                parse={APP_DATE_FORMAT}
                min={new Date()}
                placeholder="Select Date"
            />
        );
    }
}
export default DatesPicker;