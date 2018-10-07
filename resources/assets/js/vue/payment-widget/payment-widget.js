window.Vue = require('vue');

Vue.component('payment-widget', require('./template.vue'));

const app = new Vue({
    el: '#payment-widget',
});
