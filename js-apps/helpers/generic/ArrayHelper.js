import _ from 'lodash';


class ArrayHelper{
    chunck(array, size= 3){
        return _.chunk(array, size);
    }
    static chunck(array, size= 3){
        return _.chunk(array, size);
    }
    static splice(array, top){
        return _.slice(array, 0 , top);
    }
}
export default ArrayHelper;