window.Vue = require('vue');
window.axios = require('axios');
window._ = require('lodash');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('transactions-list', require('./TransactionsList.vue'));

const app = new Vue({
    el: '#transactions',
});
