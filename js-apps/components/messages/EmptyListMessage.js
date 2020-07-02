import React, { PureComponent } from 'react';


class EmptyListMessage extends PureComponent{
    constructor(props){
        super(props);
    }
    render() {
        return(
            <div>
                <h4>{this.props.message}</h4>
            </div>
        );
    }
}
export default EmptyListMessage;