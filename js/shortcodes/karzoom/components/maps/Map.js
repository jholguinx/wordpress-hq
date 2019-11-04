import React, { Component } from 'react';
import {Map,GoogleApiWrapper, Marker} from 'google-maps-react';
import { mapStyles as styles } from './styles';
import icon from '../../assets/pin.png';

export class MapContainer extends Component {
    constructor(props){
        super(props);
        this.styles = styles;
        this.state = {
            selectedMarker: {
                id: "",
                name: ""
            }
        };
    }
    onMarkerClick(){
        console.log('test');
    }
    onInfoWindowClose(){

    }

    renderMarkers() {
        return this.props.locations.map( ( location, index ) => {
            if((location.coordinates.lng) && (location.coordinates.lat)){
                return <Marker
                        key={index}
                        onClick={this.onPressMarker.bind(this, location)}
                        position={location.coordinates}
                        icon={{
                            url: ( (String(this.state.selectedMarker.id) === String(location.id)) ? "/wp-content/uploads/2019/10/pin-selected.png" : "/wp-content/uploads/2019/10/pin-normal.png" ),
                            anchor: new google.maps.Point(32,32),
                            scaledSize: new google.maps.Size(64,64)
                        }}
                    />
                }
            }
        );
    }
    onPressMarker(marker, location){
        this.setState({ selectedMarker : marker });
        this.props.onPressMarker(marker);
    }
    render() {
        return (
            <Map
                style={this.styles.mapComponentStyles}
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