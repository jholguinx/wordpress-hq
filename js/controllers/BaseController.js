import ApiConnector from "../api/ApiConnector";
import ApiConfigurationManager from "../api/ApiConfigurationManager";
import ArrayHelper from "../helpers/generic/ArrayHelper";


class BaseController{
    constructor() {
        this.connector = new ApiConnector();
        this.apiConfig = new ApiConfigurationManager();
        this.arrayHelper = new ArrayHelper();
    }
}
export default BaseController;