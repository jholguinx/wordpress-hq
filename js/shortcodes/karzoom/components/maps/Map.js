import React, { Component } from 'react';
import {Map,GoogleApiWrapper, Marker} from 'google-maps-react';
import MapMarker from "./MapMarker";

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
        return this.props.locations.map( ( location, index ) => {
            if((location.coordinates.lng) && (location.coordinates.lat)){
                return <Marker
                        key={index}
                        onClick={this.onPressMarker.bind(this, location)}
                        position={location.coordinates}
                    />
                }
            }
        );
    }
    onPressMarker(marker, location){
        this.props.onPressMarker(marker);
    }
    render() {
        return (
            <Map
                style={{width: '100%', height: '100%', position: 'relative'}}
                google={this.props.google}
                zoom={this.props.zoom}
                center={this.props.mapCenter}
                initialCenter={this.props.initialCenter}
            >
                {this.renderMarkers()}
            </Map>
        );
    }
}

export default GoogleApiWrapper({
    apiKey: ("AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE")
})(MapContainer)