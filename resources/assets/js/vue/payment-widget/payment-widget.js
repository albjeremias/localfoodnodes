window.Vue = require('vue');

Vue.component('payment-widget', require('./PaymentWidget.vue'));

const app = new Vue({
    el: '#payment-widget',
});
