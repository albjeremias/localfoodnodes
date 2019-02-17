@extends('new.layouts.simple-page', [
    'header'     => __('Support the future of food'),
    'sub_header' => __('Donate what\'s right for you'),
    'title'      => __('Membership'),
    'bg' => 'bg-accent-light-24'
])

@section('title', __('Membership'))

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                <p>{{ __('Value driven and gift based') }}</p>
                <p>{{ __('We build this platform since we believe in an internet where we can engage in real relations, where social connections can thrive and flourish without giving up our personal integrity, instead of us being the product that is sold to unknown third parties. We cheer for an Internet that enhance and drive real human relations where we as individuals feel secure in never being tools for unknown purposes, tracked in our behaviours and used to make money and impact without our knowledge.') }}</p>
                <p>{{ __('We believe none of us has to be the product in order to connect.') }}
                <p>{{ __('In order to be able to do this, instead of traditional online business models, Local Food Nodes is build on transparency and a gift economy. So, wanna get hooked up with great locally produce, digitally supported and eased by this smooth tool, support as with us much as suits you, and we will try to make magic.') }}
                </p>
            </div>

            <div class="col-16 offset-0 col-md-6 offset-md-2 offset-lg-1 offset-xl-0">
                <div id="payment-widget">
                    <payment-widget logged-in="{{ isset($user->email) }}" lang="{{ app()->getLocale() }}" publicable-key="{{ config('payment.stripe.live.publicable_key') }}" default-currency="{{ $user->currency }}"></payment-widget>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>

    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script src="{{ mix('/js/payment-widget.js') }}"></script>
@endsection