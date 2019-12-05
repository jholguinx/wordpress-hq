import React , { Component } from 'react';
import { DateTimePicker } from 'react-widgets';
import moment from 'moment';
const styles = require('../../../../../node_modules/react-widgets/dist/css/react-widgets.css');
const fonts = require('../../../../../node_modules/react-widgets/dist/fonts/rw-widgets.ttf');
const fontsTwo = require('../../../../../node_modules/react-widgets/dist/fonts/rw-widgets.woff');
import {APP_DATE_ONLY_FORMAT} from "../../App";
//https://jquense.github.io/react-widgets/api/DateTimePicker/
class DatesPicker extends Component{
    constructor(props) {
        super(props);
        this.state = {
            pickupDefault: '',
            returnDefault: ''
        };
    }
    componentDidMount() {
        let pickup = moment().add(2, 'days');
        let returnDefault = moment().add(9, 'days');
        this.setState({
            pickupDefault: pickup.toDate(),
            returnDefault: returnDefault.toDate()
        });
    }
    render() {
        return (
            <DateTimePicker
                onChange={this.props.onChange}
                value={moment(this.props.value, APP_DATE_ONLY_FORMAT).toDate()}
                defaultValue={(this.props.pickup) ? moment().add(2, 'days').add(1, 'hours').toDate() : moment().add(9, 'days').toDate()}
                format={APP_DATE_ONLY_FORMAT}
                parse={APP_DATE_ONLY_FORMAT}
                min={moment().add(2, 'days').toDate()}
                placeholder="Select Date"
                time={false}
            />
        );
    }
}
export default DatesPicker;