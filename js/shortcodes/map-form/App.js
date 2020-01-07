import ReactDOM from 'react-dom';
import React from 'react';
import HQBookingForm from "./bookingform/HQBookingForm";
import Moment from 'moment';
import momentLocalizer from 'react-widgets-moment';
Moment.locale('en');
momentLocalizer();
export const APP_DATE_FORMAT = "DD-MM-YYYY HH:mm";
export const APP_DATE_ONLY_FORMAT = "DD-MM-YYYY";
export const APP_TIME_FORMAT = "HH:mm";
/*
 *  Components
 */
ReactDOM.render(
<HQBookingForm />,
    document.getElementById("hq-map-booking-form")
);
