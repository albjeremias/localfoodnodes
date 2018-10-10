<template>
    <div>
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-center">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button v-for="year in data.years" :key="year" type="button" class="btn btn-success" v-on:click="changeYear(year)">{{ year }}</button>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-success dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                                {{ trans.currency }}: {{ this.currency }}
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <span v-for="currency in this.currencies" :key="currency.id" class="dropdown-item" v-on:click="changeCurrency(currency.currency)">{{ currency.currency }} - {{ currency.label }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <income-graph :trans="trans" :data="data.chartData.income" :total="data.total.income" :currency="currency" :year="data.filter.year"></income-graph>
            <costs-graph :trans="trans" :data="data.chartData.cost" :total="data.total.cost" :currency="currency" :year="data.filter.year"></costs-graph>
            <div class="col-12">
                <div class="text-center">
                    <h3 class="mb-0">{{ parseInt(data.total.diff).toLocaleString('sv') }} {{ currency }}</h3>
                    <div>{{ trans.available_balance }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['translations'],
        data: function() {
            return {
                currencies: null,
                currency: 'EUR',
                data: {
                    chartData: {},
                    filter: {
                        categories: null,
                        year: '2018',
                    },
                    total: {
                        income: null,
                        cost: null,
                        grouped: null,
                    },
                    transactions: null,
                    transactionsIncome: null,
                    transactionsCost: null,
                },
                loading: true,
                trans: {}, // remove
            }
        },
        components: {
            'costs-graph': require('./CostsGraph'),
            'income-graph': require('./IncomeGraph'),
        },
        mounted() {
            axios.get('/api/translations?lang=' + window.lang + '&keys=metrics')
            .then(response => {
                this.trans = response.data.data;
            });

            axios.get('/api/economy/transactions?year=2018&lang=' + window.lang)
            .then(response => {
                this.data = response.data;
                this.loading = false;
            });

            axios.get('/api/currencies')
            .then(response => {
                this.currencies = response.data;
            });
        },
        methods: {
            changeYear(year) {
                axios.get('/api/economy/transactions?currency=' + this.currency + '&year=' + year + '&lang=' + window.lang)
                .then(response => {
                    this.data = response.data;
                });
            },
            changeCurrency(currency) {
                this.loading = true;
                axios.get('/api/economy/transactions?currency=' + currency + '&year=' + this.data.filter.year + '&lang=' + window.lang)
                .then(response => {
                    this.data = response.data;
                    this.currency = currency;
                    this.loading = false;
                });
            }
        },
    }
</script>
