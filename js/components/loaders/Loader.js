import React, { PureComponent } from 'react';
import { Loader as SuiteLoader } from 'rsuite';

class Loader extends PureComponent{
    constructor() {
        super();
    }
    render() {
        return(
            <SuiteLoader
                backdrop={false}
                center={true}
                size="md"
            />
        );
    }
}
export default Loader;