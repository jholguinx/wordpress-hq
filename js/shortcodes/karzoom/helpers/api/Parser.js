

class Parser {
    static parseBrands(brands) {
        return brands.map(brand => Parser.parseBrand(brand))
    }

    static parseBrand(brand) {
        const {
            id,
            name,
            locations
        } = brand;
        return {
            id: id,
            name: name,
            locations: locations
        }
    }

    static parseLocations(locations) {
        return locations.map(location => Parser.parseLocation(location))
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
        }
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
    static parseSuggestions(){
        return [
            {
                description: "Universidad Metropolitana de Caracas, Caracas, Miranda, Venezuela",
                id: "b1464f102dd20cbd9f3d71c80cd274064e23d165",
                matched_substrings: [
                    {
                        length: 25,
                        offset: 0
                    }
                ],
                place_id: "ChIJByMUVG1XKowRfjYm4eWkajQ",
                reference: "ChIJByMUVG1XKowRfjYm4eWkajQ",
            },
            {
                description: "Universidad Metropolitana Extensión Postgrado, Calle Rivera, Puerto La Cruz, Anzoategui, Venezuela",
                id: "aa5d79f155652d09194abb5db44f84c386211c3e",
                place_id: "ChIJMaFXgyV0LYwRzettfwM8n_E",
                reference: "ChIJMaFXgyV0LYwRzettfwM8n_E",
            },
            {
                description: "Avenida Universidad Metropolitana, Caracas, Miranda, Venezuela",
                id: "903b4b2bbdbe183b005ddf9b86a600ab90929079",
                place_id: "Ej5BdmVuaWRhIFVuaXZlcnNpZGFkIE1ldHJvcG9saXRhbmEsIENhcmFjYXMsIE1pcmFuZGEsIFZlbmV6dWVsYSIuKiwKFAoSCXXTF5VtVyqMESzuWixzkr-hEhQKEgkHSILNrVgqjBGDhJkKri7dkw",
                reference: "Ej5BdmVuaWRhIFVuaXZlcnNpZGFkIE1ldHJvcG9saXRhbmEsIENhcmFjYXMsIE1pcmFuZGEsIFZlbmV6dWVsYSIuKiwKFAoSCXXTF5VtVyqMESzuWixzkr-hEhQKEgkHSILNrVgqjBGDhJkKri7dkw",
            },
            {
                description: "Entrada Universidad Metropolitana, Caracas, Capital District, Venezuela",
                id: "13b1e22f2e6c0f339156bbb6d127e714d5090064",
                place_id: "EkdFbnRyYWRhIFVuaXZlcnNpZGFkIE1ldHJvcG9saXRhbmEsIENhcmFjYXMsIENhcGl0YWwgRGlzdHJpY3QsIFZlbmV6dWVsYSIuKiwKFAoSCRV9uHoSVyqMEQxc2hEVm6KgEhQKEgkHSILNrVgqjBGDhJkKri7dkw",
                reference: "EkdFbnRyYWRhIFVuaXZlcnNpZGFkIE1ldHJvcG9saXRhbmEsIENhcmFjYXMsIENhcGl0YWwgRGlzdHJpY3QsIFZlbmV6dWVsYSIuKiwKFAoSCRV9uHoSVyqMEQxc2hEVm6KgEhQKEgkHSILNrVgqjBGDhJkKri7dkw",
            }
        ];
    }
    /*
    static parseSuggestions(predictions) {
        if (Array.isArray(predictions)) {
            return predictions.map( prediction => Parser.parseGooglePrediction(prediction) );
        }else{
            return [];
        }
    }*/
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
    /*
    static parsePlaceDetails(googlePlace){
        const {
            geometry
        } = googlePlace;
        const {
            location
        } = geometry;
        return {
            location: Parser.parseCoordinate(location)
        }
    }*/
    static parsePlaceDetails(){
        return {
            location: {
                lat: 10.5011604802915,
                lng: -66.78293951970849
            }
        };
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