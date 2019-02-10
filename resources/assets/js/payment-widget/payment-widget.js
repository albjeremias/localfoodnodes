window.Vue = require('vue');
window.axios = require('axios');

Vue.component('payment-widget', require('./template.vue'));

const app = new Vue({
    el: '#payment-widget',
});
