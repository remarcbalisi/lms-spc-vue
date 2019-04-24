import Api from './api.js';
window.api = new Api();

class Auth {
    constructor() {
        this.token = window.localStorage.getItem('token');

        let userData = window.localStorage.getItem('user');
        this.user = userData ? JSON.parse(userData) : null;

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
            axios.defaults.headers.common['Accept'] = 'application/json';
            this.getUser();
        }
    }

    login (token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        this.token = token;
        this.user = user;

        Event.$emit('userLoggedIn');
    }

    logout () {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');

        api.call('post', '/api/logout');
        Event.$emit('userLoggedOut');
    }

    check () {
        return !! this.token;
    }

    getUser() {
        return api.call('get', '/api/get-user');
    }
}

export default Auth;
