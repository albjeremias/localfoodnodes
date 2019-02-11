<template>
    <div class="payment-widget">
        <div>


                    <div class="payment-form-wrapper">
                        <form action="/account/user/membership/callback" method="post" id="payment-widget-form" v-show="!loading">

                            <!-- Backend errors -->
                            <div v-show="error" class="alert alert-secondary">
                                <i class="fa fa-warning"></i>
                                {{ this.trans[this.error] }}
                            </div>

                            <div class="form-sections">
                                <!-- Currency -->
                                <div class="form-section currency">
                                    <label>{{ trans['choose_currency'] }}</label>
                                    <div>
                                        <select v-on:change="changeCurrency" v-model="this.currency" class="form-control">
                                            <option v-for="currency in this.currencies" :key="currency.currency" :value="currency.currency">{{ currency.currency }} - {{ currency.label }}</option>
                                        </select>

                                        <input type="hidden" name="currency" :value="currency" />
                                    </div>
                                </div>

                                <!-- Amounts -->
                                <div class="form-section amount">
                                    <label>{{ trans['choose_amount'] }}</label>
                                    <div class="amounts">
                                        <input type="number" name="amount" id="amount" min="0" class="form-control" :placeholder="trans['other']">
                                    </div>
                                </div>

                                <!-- Recurring -->
                                <div class="form-section recurring">
                                    <label>{{ trans['subscription'] }} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" :title="trans['subscription_help']"></i></label>
                                    <div class="mt-2 recurring-options">
                                        <div class="recurring-button mr-2">
                                            <input type="radio" id="monthly" name="recurring" value="monthly">
                                            <label for="monthly" class="mb-0">
                                                <div class="btn btn-secondary">
                                                    <span>{{ trans['monthly'] }}</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="recurring-button mr-2">
                                            <input type="radio" id="annual" name="recurring" value="annual">
                                            <label for="annual" class="mb-0">
                                                <div class="btn btn-secondary">
                                                    <span>{{ trans['annual'] }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card -->
                                <div class="form-section credit-card">
                                    <label>{{ trans['card_details'] }}</label>
                                    <div class="form-control" id="card-element"></div>
                                    <div id="card-errors" class="alert alert-warning mt-3">
                                        <i class="fa fa-warning"></i>
                                        <span></span>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="form-section submit">
                                    <input type="hidden" name="user-action" value="login" id="form-user-action" />
                                    <div v-show="!loggedIn" class="login-signup-forms">
                                        <div class="login-form">
                                            <label>{{ trans['login'] }}</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="login-email" :placeholder="trans['your_email']">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="login-password" :placeholder="trans['your_password']">
                                            </div>
                                            <a href="#" v-on:click="createAccount">{{ trans['link_create_account'] }}</a>
                                        </div>

                                        <div class="signup-form">
                                            <label>{{ trans['create_account'] }}</label>
                                            <div class="form-group">
                                                <input type="name" class="form-control" name="signup-name" :placeholder="trans['your_name']">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="signup-email" :placeholder="trans['your_email']">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="signup-password" :placeholder="trans['choose_password']">
                                            </div>
                                            <div class="form-group">
                                                <input type="phone" class="form-control" name="signup-phone" :placeholder="trans['your_phone']">
                                                <small>{{ trans['phonenumber_info'] }}</small>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="signup-gdpr">
                                                        <div v-html="trans['gdpr_consent']"></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <a href="#" v-on:click="login">{{ trans['link_login'] }}</a>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-secondary w-100" :disabled="paymentInProgress">{{ trans['become_member'] }}</button>
                                </div>
                            </div> <!-- End .form-sections -->
                        </form>
                    </div> <!-- End payment form -->

        </div>
    </div>
</template>

<script src="./component.js"></script>
