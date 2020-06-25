import React, { Component } from 'react';
import { Loader as SuiteLoader } from 'rsuite';
import { normalLoaderStyles as styles } from './styles';
class Loader extends Component{
    constructor(props) {
        super(props);
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