import React, { Component } from 'react';

class ImageSpinner extends Component{
    constructor(props) {
        super(props);
    }
    render() {
        return(
            <div style={{ width: '100%', flex:1, justifyContent: 'center', alignItem: 'center', display: 'flex' }}>
                <img src={this.props.src} alt="spinner"/>
            </div>
        );
    }
}
export default ImageSpinner;