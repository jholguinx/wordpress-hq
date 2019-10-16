import React, { Component } from 'react';
import {Map, InfoWindow, Marker, GoogleApiWrapper} from 'google-maps-react';

export class MapContainer extends Component {
    constructor(props){
        super(props);
    }
    onMarkerClick(){
        console.log('test');
    }
    onInfoWindowClose(){
        console.log('testdasdsad');
    }
    render() {
        return (
            <Map
                google={this.props.google}
                zoom={14}
            >
                <Marker onClick={this.onMarkerClick}
                        name={'Current location'} />
                <InfoWindow onClose={this.onInfoWindowClose}>
                    <div>
                        <h1>{"dasdsa"}</h1>
                    </div>
                </InfoWindow>
            </Map>
        );
    }
}

export default GoogleApiWrapper({
    apiKey: ("AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE")
})(MapContainer)