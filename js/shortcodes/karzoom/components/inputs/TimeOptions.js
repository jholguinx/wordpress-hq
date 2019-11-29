import React , { Component } from 'react';

class TimeOptions extends Component{
    constructor(props){
        super(props);
    }
    componentDidMount() {

    }

    render(){
        return(
            <ul>

                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">4:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">5:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">5:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">6:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">6:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">7:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">7:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">8:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">8:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">9:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">9:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">10:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">10:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">11:00:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">11:30:00 AM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">12:00:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">12:30:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">1:00:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">1:30:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">2:00:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">2:30:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">3:00:00 PM</li>
                <li role="option" tabIndex="-1" aria-selected="false" className="rw-list-option">3:30:00 PM</li>

            </ul>
        );
    }
}
export default TimeOptions;