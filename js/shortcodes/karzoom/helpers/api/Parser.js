

class Parser{
    static parseBrands(brands){
        return brands.map( brand => Parser.parseBrand(brand) )
    }
    static parseBrand(brand){
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
}
export default Parser