@extends('new.account.layout',
[
    'nav_title' => __('Dashboard'),
    'sub_nav' => 'account',
    'nav_active' => 0,
    'sub_nav_active' => 0
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="container nm">
            <div class="row pt-2">
                <div class="col-md-10 col-lg-11">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="white-box little-min">
                                <h4>{{ __('Profile info') }}</h4>
                                <ul class="list-unstyled list-p">
                                    <li>{{ $user->name }}</li>
                                    <li class="black-54">{{ Auth::user()->email }}</li>
                                </ul>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <h3 class="m-0">{{ $user->nodes()->count() }}</h3>
                                        <small>{{ __('Followed nodes') }}</small>
                                    </div>

                                    <div class="col-md-4">
                                        <h3 class="m-0">{{ $user->producerAdminLinks()->count() }}</h3>
                                        <small>{{ __('Producers') }}</small>
                                    </div>

                                    <div class="col pl-md-5">
                                        <h3 class="m-0">13.5 km</h3>
                                        <small>{{ __('Average distance') }}</small>
                                    </div>
                                </div>

                                <a class="bottom-link text-uppercase rc" href="{{ route('account_user_edit') }}">{{ __('Edit profile') }}</a>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="white-box little-min">
                                <h4>{{ __('Still not a member?') }}</h4>
                                <small>{{ _('Local Food Nodes is built on a gift based economy. By donating a supporting membership fee, free of choice, you are part of financing the development of open digital tools, that supports enabling local and independent peoples driven food markets.') }}</small>
                                <a class="bottom-link text-uppercase rc" href="{{ route('membership') }}">{{ __('Membership') }}</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4 class="position-absolute">{{ __('Next pickup') }}</h4>
                                <div class="row h-100">
                                    <div class="col-16 my-auto text-center">
                                        <i class="fa fa-shopping-basket icon-big" aria-hidden="true"></i>
                                        <p class="mt-4">{{ __('No deliveries') }}</p>
                                        <a class="btn btn-primary mt-3" href="#">{{ __('Find deliveries') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4>{{ __('Nearby delivery locations') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="row">
                        <div class="col-16">
                            <div class="white-box big-min height-rmd-auto">
                                @include('new.components.nodes-following', ['nodes' => $user->nodes()])
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min height-rmd-auto">
                                <h4>{{ __('Producers I follow') }}</h4>

                                <ul class="list-unstyled node-list mt-4">
                                    <li>
                                        <div class="row no-gutters">
                                            <div class="col">
                                                <small><span class="font-italic">{{ __('Not yet available') }}</span></small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

