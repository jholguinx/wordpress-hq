

class BaseAdapter {
    static parseDataForAvailability(startDate, endDate, brandId){
        return {
            start_date: startDate,
            end_date: endDate,
            brand_id: brandId
        };
    }

}

export default BaseAdapter;