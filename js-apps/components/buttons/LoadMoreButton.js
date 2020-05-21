import React, { PureComponent } from 'react';


class LoadMoreButton extends PureComponent{
    constructor(props){
        super(props);
    }
    render() {
        return(
            <div className="filter-div">
                <a className="small-cta" id="hq-smart-load-more-button">load more +</a>
            </div>
        );
    }
}
export default LoadMoreButton;