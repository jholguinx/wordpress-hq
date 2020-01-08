

class Parser {
    static parseBrands(brands) {
        return brands.map(brand => Parser.parseBrand(brand));
    }

    static parseBrand(brand) {
        const {
            id,
            name,
            locations,
            websiteLink,
        } = brand;
        return {
            id: id,
            name: name,
            locations: locations,
            websiteLink: websiteLink,
        };
    }

    static parseLocations(locations) {
        return locations.map(location => Parser.parseLocation(location));
    }

    static parseLocation(location) {
        const {
            id,
            name,
            coordinates,
            brand_id
        } = location;
        return {
            id: id,
            name: name,
            coordinates: Parser.parseCoordinate(coordinates),
            brand_id: brand_id
        };
    }

    static parseCoordinate(coordinate) {
        try {
            const {
                lat,
                lng
            } = coordinate;
            return {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
        } catch (e) {
            return null;
        }
    }
    static parseSuggestions(predictions) {
        if (Array.isArray(predictions)) {
            return predictions.map( prediction => Parser.parseGooglePrediction(prediction) );
        }else{
            return [];
        }
    }
    static parseGooglePrediction(prediction) {
        const {
            description,
            id,
            place_id,
            reference,
        } = prediction;
        return {
            description: Parser.parseProperty(description),
            id : Parser.parseProperty(id),
            place_id : Parser.parseProperty(place_id),
            reference : Parser.parseProperty(reference),
        };
    }

    static parseProperty(prop) {
        return (prop) ? prop : '';
    }
    static parsePlaceDetails(googlePlace){
        const {
            geometry
        } = googlePlace;
        const {
            location
        } = geometry;
        return Parser.parseCoordinate(location);
    }
    static parserMakes(response){
        const {
            types
        } = response;
        return types.map( type => Parser.parseMake(type) );
    }
    static parseMake(make){
        return (make) ? (make) : '';
    }
    static parseVehicles(response){
        const {
            vehicles
        } = response;
        return vehicles.map( vehicle => Parser.parseVehicle(vehicle));
    }
    static parseVehicle(vehicle){
        return vehicle;
    }
}
export default Parser;