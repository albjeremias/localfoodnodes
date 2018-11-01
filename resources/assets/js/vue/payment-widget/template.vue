<template>
    <div class="payment-widget">
        <div>
            <div class="row">

                <div class="col-xs-12 col-md-7">
                    <div class="card-body pb-0">
                        <div class="timeline" v-show="!loading">
                            <div class="next-goal">
                                <div class="next-goal-inner">
                                    <b>{{ parseInt(members) }} {{ trans['have_become_members'] }}</b> {{ trans['lets_go_to'] }} {{ parseInt(nextGoal.members) }}!
                                </div>
                            </div>
                            <div class="line">
                                <ol ref="timeline">
                                    <li v-for="(goal, index) in goals" v-bind:key="goal.amount" :id="'goal-' + index">
                                        <div class="description">
                                            <span class="point"></span>
                                            <div class="description-inner">
                                                <div class="header">
                                                    <i class="fa fa-check-circle"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <span v-html="goal.header"></span>
                                                </div>
                                                <div class="goal">{{ trans['goal'] }}: {{ parseInt(goal.members) }} {{ trans['members'] }}</div>
                                                <div v-html="goal.desc"></div>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                                <div id="current" class="current">
                                    <div class="arrow"></div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Timeline -->
                </div> <!-- End col -->

                <div class="col-xs-12 col-md-5">

                    <div class="card">
                        <div class="card-body body-text">
                            <h6>{{ trans['value_card_title'] }}</h6>
                            <div v-html="trans['value_card_body']"></div>
                        </div>
                    </div>

                    <div class="payment-form-wrapper">
                        <form action="/account/user/membership/callback" method="post" id="payment-widget-form" v-show="!loading">

                            <!-- Backend errors -->
                            <div v-show="error" class="alert alert-secondary">
                                <i class="fa fa-warning"></i>
                                {{ this.trans[this.error] }}
                            </div>

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

                            <div class="form-section amount">
                                <div class="info">
                                    <div>{{ trans['amount_info_before'] }} <span>{{ parseInt(getAnnualGoalMembers) }}</span> {{ trans['amount_info_after'] }}</div>
                                </div>

                                <!-- Amounts -->
                                <label>{{ trans['choose_amount'] }}</label>
                                <div class="amounts">
                                    <div v-for="amount in amounts" :key="amount" class="amount-button mr-2 mb-2">
                                        <input type="radio" :id="'amount-' + amount" name="amount[]" :value="amount">
                                        <label :for="'amount-' + amount" class="mb-0">
                                            <div class="btn btn-secondary" v-on:click="setAmount(amount)">
                                                <span>{{ amount }} {{ currency }}</span>
                                            </div>
                                        </label>
                                    </div>
                                    <input type="number" name="amount-other" id="amount-other" min="0" v-on:keyup="setCustomAmount" class="amount-other form-control mb-2" :placeholder="trans['other']">
                                    <input type="hidden" name="amount" id="amount">
                                </div>
                            </div>

                            <div class="form-section recurring">
                                <!-- Recurring -->
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

                            <div class="form-section credit-card">
                                <!-- Card -->
                                <label>{{ trans['card_details'] }}</label>
                                <div id="card-element" class="mb-4"></div>
                                <div id="card-errors" class="alert alert-warning mt-3">
                                    <i class="fa fa-warning"></i>
                                    <span></span>
                                </div>
                            </div>

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

                                <button type="submit" class="btn btn-success mt-3 w-100" :disabled="paymentInProgress">{{ trans['become_member'] }}</button>
                                <div class="mt-3">
                                    <p><i>{{ trans['donation_info'] }}</i></p>
                                </div>
                            </div>
                        </form>
                    </div> <!-- End payment form -->
                </div> <!-- End col -->
            </div> <!-- End row -->
        </div>
    </div>
</template>

<script src="./component.js"></script>
