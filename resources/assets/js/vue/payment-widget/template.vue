<template>
    <div class="payment-widget">
        <div v-show="loading"><img class="loader" src="/images/loader-red.svg" /></div>
        <div v-show="!loading">
            <div class="master-alerts">
                <div class="alert alert-danger payment-errors" style="display: none;"></div>
            </div>

            <div class="card-body">
                <div class="metrics row">
                    <div class="metric col">
                        <div class="metric-inner">
                            <div class="value">{{ this.members }} st</div>
                            <div class="label">{{ this.trans.supporting_members }}</div>
                        </div>
                    </div>
                    <div class="metric col">
                        <div class="metric-inner">
                            <div class="value">{{ this.averageAmount }} {{ this.currency }}</div>
                            <div class="label">{{ this.trans.average_fee }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="/account/user/membership/callback" method="post" id="payment-widget-form">
                    <div class="form-row mb-3">
                        <div class="col">
                            <input class="form-control" type="number" step="0.01" name="amount" :placeholder="this.trans.amount" />
                        </div>

                        <div class="col">
                            <select name="currency" class="form-control" v-on:change="changeCurrency" v-model="currency">
                                <option v-for="currency in currencies" :key="currency.currency" :value="currency.currency">{{ currency.currency }} - {{ currency.label }} </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div id="card-element"></div>
                        </div>
                    </div>

                    <div id="card-errors" class="alert alert-danger mt-3"></div>

                    <div v-show="error" class="alert alert-warning mt-3 mb-0">
                        {{ this.trans[this.error] }}
                    </div>


                    <button type="submit" class="btn btn-success mt-3">{{ this.trans.become_member }}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script src="./component.js"></script>
<style scoped src="./component.css"></style>
