import React, { PureComponent } from 'react';
import { DateRangePicker as SuitePicker } from 'rsuite';
//https://rsuitejs.com/en/
class DateRangePicker extends PureComponent{
    constructor() {
        super();
    }
    render() {
        return <SuitePicker
                    onChange={this.props.onChange}
                />;
    }
}
export default DateRangePicker;