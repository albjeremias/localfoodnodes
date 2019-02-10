export default {
    props: [
        'loggedIn',
        'lang',
        'publicableKey',
        'defaultCurrency'
    ],
    data: function() {
        return {
            amount: 0,
            amounts: [10, 20, 30, 40, 50], // EUR - default value but WILL be updated,
            amountsStatic: [10, 20, 30, 40, 50], // EUR - default value but WILL NOT be updated,
            annualGoal: {
                amount: null,
                average: null,
                members: null
            },
            averageAmount: null,
            cardElement: null, // Stripe element
            currencies: [],
            currency: this.defaultCurrency ? this.defaultCurrency : 'EUR',
            error: false,
            formIsSticky: null,
            goals: [
                {
                    amount: 120000,
                    amountStatic: 120000,
                    header: '',
                    desc: '',
                },
                {
                    amount: 60000,
                    amountStatic: 60000,
                    header: '',
                    desc: '',
                },
                {
                    amount: 24000,
                    amountStatic: 24000,
                    header: '',
                    desc: '',
                },
                {
                    amount: 12000,
                    amountStatic: 12000,
                    header: '',
                    desc: '',
                },
                {
                    amount: 3000,
                    amountStatic: 3000,
                    header: '',
                    desc: '',
                },
            ],
            loadingDone: false,
            members: null,
            nextGoal: {
                amount: null,
                average: null,
                members: null
            },
            paymentInProgress: false,
            trans: {},
        }
    },
    mounted() {
        window.onresize = this.setCurrentMarkerPosition;

        this.initStripe();
        let component = this;

        axios.all([
            axios.get('https://api.localfoodnodes.org/v1.0/users/members'),
            axios.get('https://api.localfoodnodes.org/v1.0/users/amount/average?currency=' + this.currency),
            axios.get('/api/currencies'),
            axios.get('/api/translations?lang=' + this.lang + '&keys=payment_widget,stripe'),
        ])
        .then(axios.spread(function (members, averageAmount, currencies, trans) {
            component.members = members.data.data;
            component.averageAmount = averageAmount.data.data;
            component.currencies = currencies.data;
            component.trans = trans.data.data;
        }))
        .then(function() {
            component.changeCurrency(component.currency);
        })
        .then(function() {
            component.loadingDone = true;
        });

        // Check and display errors
        let uri = window.location.search.substring(1);
        let params = new URLSearchParams(uri);
        if (params.get('error')) {
            this.error = params.get('error');
        }
    },
    updated() {
        this.initNextGoalAndPosition();
    },
    computed: {
        /**
         *
         */
        getAnnualGoalMembers() {
            if (this.amount && this.annualGoal.amount && this.averageAmount) {
                let amount = this.annualGoal.amount - this.amount;
                let members = amount / this.averageAmount;

                return members > 1 ? members : 1;
            } else {
                return this.annualGoal.members;
            }
        },
        loading() {
            return !this.loadingDone;
        }
    },
    methods: {
        /**
         *
         */
        initStripe() {
            let component = this;
            let stripe = Stripe(this.publicableKey);
            let elements = stripe.elements({locale: this.lang});
            let style = {
                base: {
                    color: '#333',
                    fontSmoothing: 'antialiased',
                    fontFamily: 'montserrat',
                    fontSize: '14px',
                    lineHeight: '21px',
                    '::placeholder': {
                        color: '#999'
                    }
                },
                invalid: {
                    color: '#a94442',
                    iconColor: '#a94442',
                }
            };

            component.cardElement = elements.create('card', {style: style});
            component.cardElement.mount('#card-element');
            component.cardElement.addEventListener('change', function(event) {
                let $alert = $('#card-errors');
                if (event.error) {
                    $alert.find('span').html(event.error.message);
                    $alert.show();
                } else {
                    $alert.hide();
                    $alert.find('span').html('');
                }
            });

            let form = document.getElementById('payment-widget-form');
            form.addEventListener('submit', function(event) {
                component.paymentInProgress = true; // Set progress variable
                $('.payment-form-wrapper label.error').removeClass('error'); // Remove previous errors

                event.preventDefault();
                stripe.createToken(component.cardElement).then(function(result) {
                    if (result.error) {
                        let $alert = $('#card-errors');
                        $alert.find('span').html(result.error.message);
                        $alert.show();
                        component.paymentInProgress = false;
                    } else {
                        component.stripeTokenHandler(result.token);
                    }
                });
            });
        },

        /**
         *
         * @param {*} token
         */
        stripeTokenHandler(token) {
            let component = this;
            let $form = $('#payment-widget-form');

            // Add Stripe token
            let stripeTokenInput = document.createElement('input');
            stripeTokenInput.setAttribute('type', 'hidden');
            stripeTokenInput.setAttribute('name', 'stripeToken');
            stripeTokenInput.setAttribute('value', token.id);
            $form.append(stripeTokenInput);

            // Add CSRF-token
            let csrfToken = jQuery('meta[name="csrf-token"]').attr('content');
            let csrfTokenInput = document.createElement('input');
            csrfTokenInput.setAttribute('type', 'hidden');
            csrfTokenInput.setAttribute('name', '_token');
            csrfTokenInput.setAttribute('value', csrfToken);
            $form.append(csrfTokenInput);

            axios({
                method: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize()
            })
            .then(function(response) {
                if (response.data === true) {
                    $('#membership-modal-thanks').modal('show');
                } else {
                    $('#membership-modal-no-charge').modal('show');
                }

                // Reset state
                component.amount = 0;
                component.cardElement.clear();
                $('#amount-other').removeClass('has-value');
                $form.trigger("reset");
                component.paymentInProgress = false;
            })
            .catch(function(error) {
                error = error.response.data;

                if (error.message) {
                    let $alert = $('#card-errors');
                    $alert.find('span').html(component.trans[error.message]);
                    $alert.show();
                }

                if (error.section) {
                    $('.payment-form-wrapper .form-section.' + error.section + ' label').addClass('error');
                }

                component.paymentInProgress = false;
            });
        },

        /**
         *
         * @param {*} currency
         */
        changeCurrency(currency) {
            let component = this;

            if (typeof currency == 'object') {
                currency = currency.target.value;
            }

            let currencyRate = this.currencies[currency].rate;

            // Convert amounts to selected currency
            for (let i = 0; i < this.amountsStatic.length; i++) {
                let convertedAmount = this.amountsStatic[i] * currencyRate;
                convertedAmount = Math.ceil(convertedAmount / 5) * 5; // Convert to even 5
                this.amounts[i] = convertedAmount;
            }

            jQuery.get('https://api.localfoodnodes.org/v1.0/users/amount/average?currency=' + currency, function(res) {
                component.averageAmount = res.data;
                component.currency = currency;
            });
        },

        /**
         *
         * @param {*} amount
         */
        setAmount(amount) {
            this.amount = amount;
            $('.payment-widget #amount').val(amount);
            $('.payment-widget #amount-other').val('').removeClass('has-value');
        },

        /**
         *
         * @param {*} event
         */
        setCustomAmount(event) {
            this.amount = event.target.value;
            $('.payment-widget input[name="amount[]"]').prop('checked', false);
            $('.payment-widget #amount-other').addClass('has-value');
            $('.payment-widget #amount').val(event.target.value);
        },

        /**
         *
         */
        initNextGoalAndPosition() {
            if (this.loadingDone) {
                let total = this.members * this.averageAmount;

                for (let i = 0; i < this.goals.length; i++) {
                    let $this = $('#goal-' + i);

                    this.goals[i].header = this.trans['goal_' + i + '_header'];
                    this.goals[i].desc = this.trans['goal_' + i + '_desc'];

                    let convertedAmount = this.goals[i].amountStatic * this.currencies[this.currency].rate;;
                    this.goals[i].amount = convertedAmount;

                    this.goals[i].members = parseInt(this.goals[i].amount) / parseInt(this.averageAmount);
                    $this.data('goal', this.goals[i].amount);

                    // Annual goal
                    if (i === 0) {
                        this.annualGoal = this.goals[i];
                        this.annualGoal.average = this.goals[i].amount / this.members;
                    }

                    // Set next goal
                    if (total < this.goals[i].amount && total >= this.goals[i + 1].amount) {
                        // Check if current goal is bigger than total and if total is bigger and equal to the next goal
                        // Example array: [5, 4, 3, 2, 1, 0]
                        // If total is 3 and iteration is 4:
                        // 3 < 4 && 3 >= 3;
                        this.nextGoal = this.goals[i];
                        this.nextGoal.average = this.goals[i].amount / this.members;

                        $this.addClass('next'); // addClass('next');
                        // listElement.find('span').click();
                    }

                    // Prev
                    if (total > this.goals[i].amount) {
                        $this.addClass('prev');
                    }
                }

                this.setCurrentMarkerPosition();
            }
        },

        /**
         *
         */
        setCurrentMarkerPosition() {
            let $nextGoal = $('.timeline ol .next');
            let $lastGoal = $('.timeline ol .prev').first();

            if ($nextGoal.position() && $lastGoal.position()) {
                let total = this.members * this.averageAmount;
                let percentage = (total - $lastGoal.data('goal')) / ($nextGoal.data('goal') - $lastGoal.data('goal'));
                let diffInPixels = ($lastGoal.position().top - $nextGoal.position().top);
                let percentInPixels = diffInPixels * percentage;
                let height = $('.timeline ol').height() - $lastGoal.position().top + percentInPixels;

                $('#current').css({
                    height: height,
                    visibility: 'visible'
                });
            }
        },

        login(event) {
            event.preventDefault();
            $('#form-user-action').val('login');
            $('.signup-form').hide();
            $('.login-form').show();
        },

        createAccount(event) {
            event.preventDefault();
            $('#form-user-action').val('signup');
            $('.login-form').hide();
            $('.signup-form').show();

        },
    },
}