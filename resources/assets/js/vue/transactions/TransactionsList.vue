<template>
    <div>
        <div v-show="!loading" class="filters mb-5">
            <div>
                <button :class="yearFilter == '2018' ? 'btn btn-success' : 'btn btn-secondary'" v-on:click="filterYear('2018', $event)">2018</button>
                <button :class="yearFilter == '2017' ? 'btn btn-success' : 'btn btn-secondary'" v-on:click="filterYear('2017', $event)">2017</button>
            </div>
            <div>
                <button :class="categoryFilter == -1 ? 'btn btn-success' : 'btn btn-secondary'" v-on:click="filterTransactions(-1, $event)">{{ trans.all }}</button>
                <button :class="categoryFilter == categories.income ? 'btn btn-success' : 'btn btn-secondary'" v-on:click="filterTransactions(categories.income, $event)">{{ trans.all_incomes }}</button>
                <button :class="categoryFilter == categories.cost ? 'btn btn-success' : 'btn btn-secondary'" v-on:click="filterTransactions(categories.cost, $event)">{{ trans.all_costs}}</button>
            </div>
            <div>
                <button v-for="category in this.categories.all" v-bind:key="category.id" v-on:click="(filterTransactions(category.id, $event))" :class="categoryFilter.indexOf(category.id) != -1 ? 'btn btn-success' : 'btn btn-secondary'">{{ trans['category_' + category.id] }}</button>
            </div>
        </div>

        <i v-show="loading" class="fa fa-spinner fa-spin loader"></i>
        <div class="table-responsive">
            <table v-show="!loading" class="table table-hover">
                <thead>
                    <tr>
                        <th>{{ trans.date }}</th>
                        <th>{{ trans.ref }}</th>
                        <th>{{ trans.description }}</th>
                        <th>
                            <div class="dropdown">
                                <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                                    {{ trans.amount }} {{ this.currency }}
                                </span>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <span v-for="currency in this.currencies" :key="currency.id" class="dropdown-item" v-on:click="changeCurrency(currency.currency)">{{ currency.currency }} {{ currency.label }}</span>
                                </div>
                            </div>
                        </th>

                        <th>{{ trans.category }}</th>
                    </tr>
                </thead>

                <tbody>
                    <transaction-item
                        v-for="transaction in filteredTransactions"
                        :transaction="transaction"
                        :categories="categories.all"
                        :key="transaction.hash">
                    </transaction-item>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
    .table th {
        font-size: 14px;
    }
    .btn {
        text-transform: capitalize;
        font-size: 12px;
        margin: 5px;
        padding: 5px 10px;
    }
</style>

<script>
    export default {
        props: ['translations'],
        components: {
            'transaction-item': require('./TransactionItem'),
        },
        data: function() {
            return {
                categories: {
                    all: null,
                    income: null,
                    cost: null
                },
                categoryFilter: [],
                currencies: null,
                currency: 'EUR',
                filteredTransactions: null,
                loading: true,
                trans: {},
                transactions: null,
                yearFilter: '2018',
            };
        },
        mounted() {
            axios.get('/api/translations?lang=' + window.lang + '&keys=metrics')
            .then(response => {
                this.trans = response.data.data;
            });

            axios.get('/api/economy/transactions?lang=' + window.lang)
            .then(response => {
                this.transactions = response.data.transactions.all;
                this.filteredTransactions = response.data.transactions.all;
                this.categories = response.data.categories;
                this.loading = false;
            });

            axios.get('/api/currencies')
            .then(response => {
                this.currencies = response.data;
            });
        },
        methods: {
            getFilter() {
                let filters = this.categories.all.concat()
            },
            setSelectedFilter(filter) {
                this.selectedFilters.push(filter);
            },
            filterTransactions(categoryFilter, event) {
                if (!_.isArray(categoryFilter)) {
                    categoryFilter = [categoryFilter];
                }

                if (_.includes(categoryFilter, -1)) {
                    // Reset, show all
                    this.filteredTransactions = this.transactions;
                    this.selectedFilters = [];
                } else {
                    // Filter on select category
                    this.filteredTransactions = _.filter(this.transactions, transaction => {
                        return _.includes(categoryFilter, parseInt(transaction.category));
                    });
                }

                this.categoryFilter = categoryFilter;
            },
            filterYear(yearFilter, event) {
                this.filteredTransactions = _.filter(this.transactions, transaction => {
                    return transaction.date.substr(0, 4) === yearFilter;
                });

                this.yearFilter = yearFilter;
                this.categoryFilter = [];
            },
            changeCurrency(currency) {
                this.loading = true;
                this.currency = currency;

                axios.get('/api/economy/transactions?currency=' + currency +'&lang=' + window.lang)
                .then(response => {
                    this.transactions = response.data.transactions;
                    this.filteredTransactions = response.data.transactions;
                    this.categories = response.data.categories;
                    this.loading = false;
                });
            }
        }
    }
</script>
