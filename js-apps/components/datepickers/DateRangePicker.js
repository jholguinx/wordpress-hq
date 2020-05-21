import React, { PureComponent } from 'react';
import { DateRangePicker as SuitePicker } from 'rsuite';
//https://rsuitejs.com/en/
class DateRangePicker extends PureComponent{
    constructor() {
        super();
    }
    render() {
        return <SuitePicker
                    style={{ minWidth: 230 }}
                    onChange={this.props.onChange}
                    value={this.props.value}
                />;
    }
}
export default DateRangePicker;