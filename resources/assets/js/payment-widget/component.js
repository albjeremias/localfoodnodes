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
            averageAmount: null,
            cardElement: null, // Stripe element
            currencies: [],
            currency: this.defaultCurrency ? this.defaultCurrency : 'EUR',
            error: false,
            formIsSticky: null,
            loadingDone: false,
            members: null,
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
        .then(axios.spread((members, averageAmount, currencies, trans) => {
            component.members = members.data.data;
            component.averageAmount = averageAmount.data.data;
            component.currencies = currencies.data;
            component.trans = trans.data.data;
        }))
        .then(() => {
            component.changeCurrency(component.currency);
        })
        .then(() => {
            component.loadingDone = true;
        })
        .catch(error => {
            console.error(error);
        });

        // Check and display errors
        let uri = window.location.search.substring(1);
        let params = new URLSearchParams(uri);
        if (params.get('error')) {
            this.error = params.get('error');
        }
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
                    borderColor: '#9e9e9e',
                    color: '#333',
                    fontSmoothing: 'antialiased',
                    fontFamily: 'montserrat',
                    fontSize: '0.88rem',
                    fontWeight: 600,
                    lineHeight: '25px',
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
                $form.trigger('reset');
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