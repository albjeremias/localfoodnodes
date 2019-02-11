window.Vue = require('vue');
window.axios = require('axios');

Vue.component('payment-widget', require('./template.vue').default);

const app = new Vue({
    el: '#payment-widget',
});
