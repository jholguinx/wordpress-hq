import ApiConnector from "../api/ApiConnector";
import ApiConfigurationManager from "../api/ApiConfigurationManager";


class BaseController{
    constructor() {
        this.connector = new ApiConnector();
        this.apiConfig = new ApiConfigurationManager();
    }
}
export default BaseController;