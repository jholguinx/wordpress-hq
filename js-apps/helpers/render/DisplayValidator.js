

class DisplayValidator {
    static validateArrayAndDisplay(data, componentOrFunction){
        if (Array.isArray(data)){
            if(data.length > 0){
                if(typeof componentOrFunction === 'function'){
                    return componentOrFunction();
                }else{
                    return componentOrFunction;
                }
            }
        }
    }
}
export default DisplayValidator;