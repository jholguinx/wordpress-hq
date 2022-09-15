import { defineConfig } from 'cypress';
const test = require('./.test.config.js');
// please create a .test.config.json file with the baseURL
export default defineConfig({
    e2e: {
        baseUrl: test.baseURL,
        defaultCommandTimeout: 10000
    }
})