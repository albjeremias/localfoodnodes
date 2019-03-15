<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12 mb-5">
            <i v-show="loading" class="fa fa-spinner fa-spin loader"></i>
            <div v-show="!loading" class="row metrics">
                <div class="metric">
                    <div class="metric-inner">
                        <div class="value">{{ data.products }}</div>
                        <div class="label">{{ this.trans.unique_products }}</div>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-inner">
                        <div class="value">{{ data.count }}</div>
                        <div class="label">{{ this.trans.items_sold }}</div>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-inner">
                        <div class="value">{{ parseInt(data.circulation).toLocaleString('sv') }} {{ currency }}</div>
                        <div class="label">{{ this.trans.money_circulated }}</div>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                    {{ this.trans.change_currency }}: {{ this.currency }}
                </span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <span v-for="currency in this.currencies" :key="currency.id" class="dropdown-item" v-on:click="changeCurrency(currency.currency)">{{ currency.currency }} {{ currency.label }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .metrics {
        display: flex;
        justify-content: center;
    }
    .metric {
        align-items: center;
        background: #d6c69b;
        border-radius: 100%;
        color: #fff;
        display: flex;
        height: 200px;
        justify-content: center;
        margin: 1rem;
        width: 200px;
    }
    .metric-inner {
        align-items: center;
        background: #d6c69b;
        border: 2px dashed #fff;
        border-radius: 100%;
        display: flex;
        flex-direction: column;
        height: 190px;
        justify-content: center;
        padding-top: 15px;
        text-align: center;
        width: 190px;
    }
    .metric-inner .value {
        font-size: 24px;
        font-weight: bold;
    }
    .metric-inner .label {
        font-weight: bold;
        margin-top: 5px;
    }
</style>

<script>
    export default {
        props: ['translations'],
        data: function() {
            return {
                currency: 'EUR',
                currencies: null,
                data: {
                    circulation: null,
                    count: null,
                    products: null
                },
                trans: {}
            }
        },
        mounted() {
            axios.get('/api/translations?lang=' + window.lang + '&keys=metrics')
            .then(response => {
                this.trans = response.data.data;
            });

            axios.get('https://api.localfoodnodes.org/v1.0/orders/amount?currency=' + this.currency)
            .then(response => {
                this.data.circulation = response.data.data;
            });

            axios.get('https://api.localfoodnodes.org/v1.0/orders/count')
            .then(response => {
                this.data.count = response.data.data;
            });

            axios.get('https://api.localfoodnodes.org/v1.0/orders/products')
            .then(response => {
                this.data.products = response.data.data;
            });

            axios.get('/api/currencies')
            .then(response => {
                this.currencies = response.data;
            });
        },
        methods: {
            changeCurrency(currency) {
                axios.get('https://api.localfoodnodes.org/v1.0/orders/amount?currency=' + currency)
                .then(response => {
                    this.data.circulation = response.data.data;
                    this.currency = currency;
                });
            }
        },
        computed: {
            loading: function() {
                return (this.data.count && this.data.products && this.data.circulation) ? false : true;
            }
        }
    }
</script>
