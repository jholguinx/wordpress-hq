

class BaseAdapter {
    static parseDataForAvailability(startDate, endDate, brandId){
        return {
            start_date: startDate,
            end_date: endDate,
            brand_id: brandId
        };
    }
    static adaptRecursively(object, defaultValue = '') {
        let objectToReturn = {};
        for (let [key, value] of Object.entries(object)) {
            if (value === null) {
                objectToReturn[key] = BaseAdapter.getDataFromProperty(
                    value,
                    defaultValue,
                );
            } else if (Array.isArray(value)) {
                objectToReturn[key] = value.map(item => {
                    if (BaseAdapter.isFinalElement(item)) {
                        return BaseAdapter.getDataFromProperty(item);
                    } else {
                        return BaseAdapter.adaptRecursively(item);
                    }
                });
            } else if (typeof value === 'object') {
                objectToReturn[key] = BaseAdapter.adaptRecursively(
                    value,
                    defaultValue,
                );
            } else if (typeof value === 'string') {
                objectToReturn[key] = BaseAdapter.getDataFromProperty(
                    value,
                    defaultValue,
                );
            } else {
                objectToReturn[key] = BaseAdapter.getDataFromProperty(
                    value,
                    defaultValue,
                );
            }
        }
        return objectToReturn;
    }
    static isFinalElement(data) {
        return (
            typeof data === 'string' ||
            typeof data === 'boolean' ||
            typeof data === 'number'
        );
    }

    static adaptWithDefaultValues(object, defaultValue = '') {
        return object ? BaseAdapter.adaptRecursively(object) : defaultValue;
    }

    static adaptArray(array) {
        if (Array.isArray(array)) {
            return array.map(item => BaseAdapter.adaptRecursively(item));
        }
        return [];
    }
    static getDataFromObject(object, property, defaultValue = '') {
        return object
            ? object[property]
                ? object[property]
                : defaultValue
            : defaultValue;
    }

    static getDataFromProperty(property, defaultValue = '') {
        return property ? property : defaultValue;
    }

}

export default BaseAdapter;