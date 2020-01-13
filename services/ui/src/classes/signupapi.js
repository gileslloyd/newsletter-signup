import axios from 'axios';

axios.defaults.headers.common['api-key'] = 'P!d,sZ%LddTs|q&3rf-YmLag0q2K[-7O-e:[:RV|hk]so/?{2E=30|:p>i9!tt';
axios.defaults.validateStatus = (status) => {
    if (status === 401) {
        sessionStorage.removeItem('auth-token');
        var event = new CustomEvent('auth-error');
        window.dispatchEvent(event);
        return false;
    }

    return true;
};

const env = process.env.NODE_ENV;
const dev = env !== "production";

var SignupAPI = {
    config: {
        domain: dev ? 'http://api.local/' : 'https://api.features.aws.prop.cm/'
    },

    setAuthToken(token) {
        axios.defaults.headers.common['Authorization'] = token;
    },

    get(url, callback) {
        axios.get(this.config.domain+url).then(callback);
    },

    put(url, data, callback) {
        axios.put(this.config.domain+url, data).then(callback);
    },

    post(url, data, callback) {
        axios.post(this.config.domain+url, data).then(callback);
    }
};

export default SignupAPI;
