
import { SYSTEM_API_DATE_FORMAT, SYSTEM_API_DATE_FORMAT_DATE_ONLY } from '../../env';
import moment from "moment";

class DateHelper{
    static nowForSystem(){
        return moment().format(SYSTEM_API_DATE_FORMAT);
    }
    static daysFromNow(numberOfDays){
        return moment().add(numberOfDays, 'days').format(SYSTEM_API_DATE_FORMAT);
    }
    static nowDate(){
        return moment().toDate();
    }
    static daysFromNowDate(numberOfDays){
        return moment().add(numberOfDays, 'days').toDate();
    }
    static nowDateForSystem(){
        return moment().format(SYSTEM_API_DATE_FORMAT_DATE_ONLY)
    }
    static daysFromNowJustDate(numberOfDays){
        return moment().add(numberOfDays, 'days').format(SYSTEM_API_DATE_FORMAT_DATE_ONLY)
    }
}
export default DateHelper;