<div class="master-alerts">
    <div class="alert alert-danger payment-errors" style="display: none;"></div>
</div>

<div class="card-body">
    <div class="metrics row">
        <div class="metric col">
            <div class="metric-inner">
                <div class="value">{{ $members }} st</div>
                <div class="label">{{ trans('public/pages/membership.supporting') }}</div>
            </div>
        </div>
        <div class="metric col">
            <div class="metric-inner">
                <div class="value">{{ $averageMembership }} SEK</div>
                <div class="label">{{ trans('public/pages/membership.avg_fee') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-body">
    <form action="/account/user/membership/callback" method="post" id="payment-form">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <input type="number" placeholder="{{ trans('admin/user.amount') }}" name="amount" class="form-control"/>
            <select class="custom-select" id="inputGroupSelect01">
                @foreach (config('app.currencies') as $code => $currency)
                    <option {{ $code === $user->currency ? 'selected' : '' }} value="{{ $code }}">{{ $code }} - {{ $currency }}</a>
                @endforeach
            </select>
        </div>

        <div id="card-element"></div>
        <div><small>{!! trans('admin/user.payment_info') !!}</small></div>
        <div id="card-errors" class="alert alert-danger mt-3 mb-0" role="alert"></div>

        @if (isset($_GET['error']))
            <div class="alert alert-warning mt-3 mb-0">
                {!! trans('admin/user.error_' . $_GET['error']) !!}
            </div>
        @endif

        <button class="btn btn-success mt-3">{{ trans('admin/user.submit_payment') }}</button>
    </form>
</div>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script>
    $(function() {
        var stripe = Stripe('{{ config('payment.stripe.live.publicable_key') }}');
        var elements = stripe.elements({locale: 'sv'});
        var style = {
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

        var card = elements.create('card', {style: style});
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var error = document.getElementById('card-errors');
            if (event.error) {
                error.textContent = event.error.message;
                $(error).show();
            } else {
                $(error).hide();
                error.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>

<style>
    .StripeElement {
        background-color: white;
        padding: .375rem .75rem;
        border: 1px solid #c5c5bc;
        border-radius: 3px;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--invalid {
        border-color: #f5c6cb;
    }

    #card-errors {
        display: none;
    }
</style>

@section('modal')
    @if (Session::has('membership_modal_no_charge'))
        <div class="modal fade" id="membership-modal-no-charge" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('admin/user.membership_modal_title') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body body-text">
                        {!! trans('admin/user.membership_modal_no_charge') !!}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#membership-modal-no-charge').modal('show');
        </script>
    @elseif (Session::has('membership_modal_thanks'))
        <div class="modal fade" id="membership-modal-thanks" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('admin/user.membership_modal_title') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body body-text">
                        {!! trans('admin/user.membership_modal_thanks') !!}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#membership-modal-thanks').modal('show');
        </script>
    @endif
@endsection
