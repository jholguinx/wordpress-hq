import React, { Component } from 'react';
import {Marker} from 'google-maps-react';

class MapMarker extends Component {
    constructor(props){
        super(props);
    }
    onMarkerClick(marker){
        this.props.onPressMarker(marker);
    }
    render() {
        console.log(this.props.location.coordinates);
        return (
            <Marker
                id={this.props.location.id}
                name={this.props.location.name}
                position={this.props.location.coordinates}
                title={'test'}
            />
        );
    }
}
export default MapMarker;