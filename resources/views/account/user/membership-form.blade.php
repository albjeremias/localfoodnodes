<div class="master-alerts">
    <div class="alert alert-danger payment-errors" style="display: none;"></div>
</div>

<form action="/account/user/membership/callback" method="POST" class="form" id="payment-form">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-header">{{ trans('admin/user.membership') }}</div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-control-label" for="amount">{{ trans('admin/user.amount') }} (SEK)</label>
                <div class="input-group">
                    <input type="number" name="amount" id="amount" class="form-control" data-stripe="amount" placeholder="{{ trans('admin/user.amount') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-control-label" for="number">{{ trans('admin/user.card_number') }}</label>
                <div class="input-group">
                    <input type="text" id="number" class="form-control" size="20" data-stripe="number" placeholder="{{ trans('admin/user.card_number') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ trans('admin/user.card_expiration') }}</label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" class="form-control"  size="2" data-stripe="exp_month" placeholder="{{ trans('admin/user.month') }}">
                    </div>
                    <div class="col-6">
                        <input type="number" class="form-control"  size="2" data-stripe="exp_year" placeholder="{{ trans('admin/user.year') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ trans('admin/user.card_cvc') }}</label>
                <input type="number" class="form-control"  size="4" data-stripe="cvc" placeholder="{{ trans('admin/user.card_cvc') }}">
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ trans('admin/user.your_zip_code') }}</label>
                <input type="number" class="form-control" size="6" data-stripe="address_zip" placeholder="{{ trans('admin/user.your_zip_code') }}" value="{{ $user->zip or '' }}">
            </div>
            <span>{!! trans('admin/user.payment_info') !!}</span>
        </div>
        <div class="card-body">
            <input type="submit" class="submit btn btn-success" value="{{ trans('admin/user.submit_payment') }}">
        </div>
    </div>
</form>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('{{ config('payment.stripe.live.publicable_key') }}');

    $(function() {
        var $form = $('#payment-form');
        $form.submit(function(event) {
            $form.find('.submit').prop('disabled', true);
            // Request a token from Stripe
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#payment-form');

        if (response.error) {
            $('.payment-errors').show().text(response.error.message);
            $form.find('.submit').prop('disabled', false); // Re-enable submission
        } else {
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken">').val(token));
            $form.get(0).submit();
        }
    };
</script>

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
