import ReactDOM from 'react-dom';
import React from 'react';
import HQBookingForm from "./bookingform/HQBookingForm";
import Moment from 'moment'
import momentLocalizer from 'react-widgets-moment';
Moment.locale('en');
momentLocalizer();

/*
 *  Components
 */
ReactDOM.render(
<HQBookingForm />,
    document.getElementById("hq-booking-form-karzoom")
);
