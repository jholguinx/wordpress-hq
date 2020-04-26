import React, { PureComponent } from 'react';
import { Loader as SuiteLoader } from 'rsuite';

class Loader extends PureComponent{
    constructor() {
        super();
    }
    render() {
        return(
            <SuiteLoader
                style={{ marginTop: 20, marginBottom: 20,position: 'relative', display: 'flex', justifyContent: 'center', alignItems: 'center' }}
                backdrop={false}
                center={true}
                size="md"
            />
        );
    }
}
export default Loader;