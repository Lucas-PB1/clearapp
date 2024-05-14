// Bootstrap
import 'bootstrap';

// Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Jquery
import jQuery from 'jquery';
window.$ = jQuery;
