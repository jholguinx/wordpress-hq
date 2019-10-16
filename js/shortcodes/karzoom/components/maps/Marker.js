import React, { PureComponent } from 'react';
import {Marker} from 'google-maps-react';

export class Marker extends PureComponent {
    constructor(props){
        super(props);
    }
    onMarkerClick(marker){
        this.props.onPressMarker(marker);
    }
    render() {
        return (
            <Marker onClick={this.onMarkerClick}
                    name={this.props.name}
            />
        );
    }
}
export default Marker;