<div id="payment-widget">
    <payment-widget publicable-key="{{ config('payment.stripe.live.publicable_key') }}" default-currency="SEK"></payment-widget>
</div>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script src="{{ mix('/js/payment-widget.js') }}"></script>

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
            $(function() {
                $('#membership-modal-no-charge').modal({show: true});
            });
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
            $(function() {
                $('#membership-modal-thanks').modal({show: true});
            });
        </script>
    @endif
@endsection
