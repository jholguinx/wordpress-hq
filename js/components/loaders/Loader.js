import React, { PureComponent } from 'react';
import { Loader as SuiteLoader } from 'rsuite';
import { normalLoaderStyles as styles } from './styles';
class Loader extends PureComponent{
    constructor() {
        super();
    }
    render() {
        return(
            <SuiteLoader
                style={styles.loader}
                backdrop={false}
                center={true}
                size="md"
            />
        );
    }
}
export default Loader;