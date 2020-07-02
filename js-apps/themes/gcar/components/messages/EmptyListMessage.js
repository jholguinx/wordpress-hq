import React, { Component } from 'react';

class EmptyListMessage extends Component{
    constructor(props) {
        super(props);
    }
    render() {
        return(
            <p style={{ textAlign: 'center' }}>{this.props.message}</p>
        );
    }
}
export default EmptyListMessage;