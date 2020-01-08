import React , { Component } from 'react';
import { DateTimePicker } from 'react-widgets';
import moment from 'moment';
const styles = require('../../../../../node_modules/react-widgets/dist/css/react-widgets.css');
const fonts = require('../../../../../node_modules/react-widgets/dist/fonts/rw-widgets.ttf');
const fontsTwo = require('../../../../../node_modules/react-widgets/dist/fonts/rw-widgets.woff');
import { APP_DATE_FORMAT, APP_TIME_FORMAT } from "../../App";
import business from 'moment-business';
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
    onChangeTime(time){
        const parseDate = moment(time);
        this.props.onChange(time);/*
        if(this.isOfficeHour(parseDate)){

        }else{
            alert("This office is not open at this hour. Please Select another time.");
        }*/

    }
    isOfficeHour(momentDate){
        const selectedTime = moment(momentDate, APP_TIME_FORMAT);
        if(business.isWeekDay(momentDate)){
            const beforeTime = moment("08:00" , APP_TIME_FORMAT);
            const afterTime = moment("18:00" , APP_TIME_FORMAT);
            if( selectedTime.isBetween(beforeTime, afterTime) ){
                return true;
            }
            return false;
        }else if(business.isWeekendDay(momentDate)){
            const beforeTime = moment("09:00", APP_TIME_FORMAT);
            const afterTime = moment("17:00", APP_TIME_FORMAT);
            if(selectedTime.isBetween(beforeTime,afterTime)){
                return true;
            }
            return false;
        }else{
            return false;
        }
    }
    render() {
        return (
            <DateTimePicker
                onChange={this.onChangeTime.bind(this)}
                value={moment(this.props.value, APP_DATE_FORMAT).toDate()}
                defaultValue={(this.props.pickup) ? moment().add(2, 'days').add(1, 'hours').toDate() : moment().add(9, 'days').toDate()}
                format={APP_DATE_FORMAT}
                timeFormat={APP_TIME_FORMAT}
                parse={APP_DATE_FORMAT}
                min={moment().add(2, 'days').toDate()}
                placeholder="Select Date"
                time={true}
            />
        );
    }
}
export default DatesPicker;