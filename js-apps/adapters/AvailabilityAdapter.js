import BaseAdapter from './BaseAdapter';
import ArrayHelper from "../helpers/generic/ArrayHelper";

class AvailabilityAdapter extends BaseAdapter{
    constructor() {
        super();
    }
    static adaptAvailabilityResponse(data){
        return data.map( vehicle => AvailabilityAdapter.adaptVehicleOnAvailabilityResponse(vehicle) );
    }
    static adaptAvailabilityResponseForComponent(data){
        if(Array.isArray(data)){
            const arrayHelper = new ArrayHelper();
            return arrayHelper.chunck(AvailabilityAdapter.adaptAvailabilityResponse(data));
        }else{
            return [];
        }
    }
    static adaptVehicleOnAvailabilityResponse(vehicle){
        return {
            ...AvailabilityAdapter.adaptRecursively(vehicle)
        }
    }
}
export default AvailabilityAdapter;