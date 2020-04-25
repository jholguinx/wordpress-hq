
import { SYSTEM_API_DATE_FORMAT } from '../../env';
import moment from "moment";

class DateHelper{
    static nowForSystem(){
        return moment().format(SYSTEM_API_DATE_FORMAT);
    }
    static daysFromNow(numberOfDays){
        return moment().add(numberOfDays, 'days').format(SYSTEM_API_DATE_FORMAT);
    }
}
export default DateHelper;