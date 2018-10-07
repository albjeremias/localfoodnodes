<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 mb-5">
            <i v-show="loading" class="fa fa-spinner fa-spin loader"></i>
            <div v-show="!loading" class="row metrics">
                <div class="metric col-6">
                    <i class="fa fa-shopping-cart"></i>
                    <div class="metric-inner">
                        <div class="value">{{ data.count }}</div>
                        <div class="label">{{ this.trans.orders }}</div>
                    </div>
                </div>
                <div class="metric col-6">
                    <i class="fa fa-refresh"></i>
                    <div class="metric-inner">
                        <div class="value">{{ parseInt(data.circulation).toLocaleString('sv') }}</div>
                        <div class="label">{{ this.trans.money_circulated }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .metric .fa,
    .metric .value {
        color: #666
    }
</style>

<script>
    export default {
        props: ['translations'],
        data: function() {
            return {
                data: {
                    circulation: null,
                    count: null
                },
                loading: true,
                trans: {}
            }
        },
        mounted() {
            this.trans = JSON.parse(this.translations);
            axios.get('https://api.localfoodnodes.org/v1.0/orders/amount')
            .then(response => {
                this.data.circulation = response.data.data;
                this.loading = this.isLoadingComplete();
            });

            axios.get('https://api.localfoodnodes.org/v1.0/orders/count')
            .then(response => {
                this.data.count = response.data.data;
                this.loading = this.isLoadingComplete();
            });
        },
        methods: {
            isLoadingComplete() {
                return (this.data.count && this.data.circulation) ? false : true;
            },
        }
    }
</script>
