import _ from 'lodash';


class ArrayHelper{
    chunck(array, size= 3){
        return _.chunk(array, size);
    }
}
export default ArrayHelper;