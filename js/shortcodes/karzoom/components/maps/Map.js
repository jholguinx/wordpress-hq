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
    renderMarkers() {
        this.props.markers.map(marker =>
            <Marker
                onPressMarker={this.onPressMarker}
            />
        );
    }
    onPressMarker(marker){
        this.props.onPressMarker(marker);
    }
    render() {
        return (
            <Map
                google={this.props.google}
                zoom={this.props.zoom}
                mapCenter={this.props.mapCenter}
            >
                {this.renderMarkers}
            </Map>
        );
    }
}

export default GoogleApiWrapper({
    apiKey: ("AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE")
})(MapContainer)