import React, { Component } from 'react';


class SubmitButton extends Component{
    constructor(props) {
        super(props);
    }
    render() {
        return(
            <button id="car_search_btn" type="submit" className="button"
                   defaultValue="Search" style={{ width: '100%' }}>
                {'Submit'}
            </button>
        );
    }
}
export default SubmitButton;