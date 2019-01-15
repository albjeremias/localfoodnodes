@extends('public.layout-page', [
    'header' => trans('public/pages/membership.header'),
    'subHeader' => trans('public/pages/membership.sub_header'),
    'image' => '/images/shutterstock_436974091.jpg'
])

@section('title', trans('public/pages/membership.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="master-alerts">
                    <div class="alert alert-danger payment-errors" style="display: none;"></div>
                </div>
            </div>

            <div class="col-12">
                <div class="card-deck">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="bold">{{ trans('public/pages/membership.top_card_title') }}</h2>
                            <p class="body-text">{{ trans('public/pages/membership.top_card_body') }}</p>

                            <div class="row">
                                {!! trans('public/pages/membership.top_card_lists') !!}
                            </div>
                        </div>
                    </div> <!-- End card -->
                </div>
            </div> <!-- End card deck -->
        </div>

        <div id="payment-widget" class="mt-5">
            <payment-widget logged-in="{{ isset($user->email) }}" lang="{{ app()->getLocale() }}" publicable-key="{{ config('payment.stripe.live.publicable_key') }}" default-currency="{{ $user->currency }}"></payment-widget>
        </div>
    </div>

    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script src="{{ mix('/js/payment-widget.js') }}"></script>

    @section('modal')
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
    @endsection
@endsection
{{--
@section('modal')
    <div class="modal fade" id="terms-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('admin/user.terms_of_use') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body body-text">
                    <p>{!! trans('admin/terms.user') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection --}}