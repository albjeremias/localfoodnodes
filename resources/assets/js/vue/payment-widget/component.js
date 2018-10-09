export default {
    props: [
        'publicableKey',
        'defaultCurrency'
    ],
    data: function() {
        return {
            averageAmount: null,
            currencies: [],
            currency: this.defaultCurrency,
            error: false,
            members: null,
            trans: {
                amount: 'Amount',
                average_fee: 'Supporting members',
                become_member: 'Become a member',
                supporting_members: 'Supporting members',
            },
        }
    },
    mounted() {
        this.initStripe();
        let component = this;

        jQuery.get('https://api.localfoodnodes.org/v1.0/users/members', function(res) {
            component.members = res.data;
        });

        jQuery.get('https://localfoodnodes.org/api/currencies', function(res) {
            component.currencies = res;
        });

        jQuery.get('https://api.localfoodnodes.org/v1.0/users/amount/average/' + this.currency, function(res) {
            component.averageAmount = Math.round(res.data);
        });

        jQuery.get('https://localfoodnodes.org/api/translations?keys=payment_widget,stripe', function(res) {
            component.trans = res.data;
        });

        // Check and display errors
        let uri = window.location.search.substring(1);
        let params = new URLSearchParams(uri);
        if (params.get('error')) {
            this.error = params.get('error');
        }
    },
    methods: {
        initStripe() {
            let component = this;
            let stripe = Stripe(this.publicableKey);
            let elements = stripe.elements({locale: 'sv'});
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

            let card = elements.create('card', {style: style});
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                let error = document.getElementById('card-errors');
                if (event.error) {
                    error.textContent = event.error.message;
                    jQuery(error).show();
                } else {
                    jQuery(error).hide();
                    error.textContent = '';
                }
            });

            let form = document.getElementById('payment-widget-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        let errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        component.stripeTokenHandler(result.token);
                    }
                });
            });
        },
        stripeTokenHandler(token) {
            let form = document.getElementById('payment-widget-form');

            // Add Stripe token
            let stripeTokenInput = document.createElement('input');
            stripeTokenInput.setAttribute('type', 'hidden');
            stripeTokenInput.setAttribute('name', 'stripeToken');
            stripeTokenInput.setAttribute('value', token.id);
            form.appendChild(stripeTokenInput);

            // Add CSRF-token
            let csrfToken = jQuery('meta[name="csrf-token"]').attr('content');
            let csrfTokenInput = document.createElement('input');
            csrfTokenInput.setAttribute('type', 'hidden');
            csrfTokenInput.setAttribute('name', '_token');
            csrfTokenInput.setAttribute('value', csrfToken);
            form.appendChild(csrfTokenInput);

            form.submit();
        },
        changeCurrency(event) {
            let vue = this;
            jQuery.get('https://api.localfoodnodes.org/v1.0/users/amount/average/' + event.target.value, function(res) {
                vue.averageAmount = Math.round(res.data);
                vue.currency = event.target.value;
            });
        }
    },
    computed: {
        loading: function () {
            if (this.members && this.currency && this.averageAmount && this.trans) {
                return false;
            }

            return true;
        }
    }
}