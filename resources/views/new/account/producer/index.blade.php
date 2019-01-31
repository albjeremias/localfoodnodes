@extends('new.account.layout',
[
    'nav_title' => __('My dashboard'),
    'sub_nav' => 'producer',
    'nav_active' => 1,
    'sub_nav_active' => 0,
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
                                <h4>{{ $producer->name }}</h4>
                                <ul class="list-unstyled list-p">
                                    <li>{{ Auth::user()->name }}</li>
                                    <li class="black-54">{{ Auth::user()->email }}</li>
                                    <li class="black-54">{{ $producer->address }}</li>
                                    <li class="black-54">{{ $producer->zip }} {{ $producer->city }}</li>
                                </ul>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h3 class="m-0">1129</h3>
                                        <small>{{ __('Attended pickups') }}</small>
                                    </div>

                                    <div class="col-md-4">
                                        <h3 class="m-0">41</h3>
                                        <small>{{ __('Products sold') }}</small>
                                    </div>

                                    <div class="col pl-md-5">
                                        <h3 class="m-0">13.5 km</h3>
                                        <small>{{ __('Turnover') }}</small>
                                    </div>
                                </div>

                                <a class="bottom-link text-uppercase rc" href="#">{{ __('Edit profile') }}</a>
                                <span class="bottom-link-right" href="#">
                                    <small class="font-italic" data-toggle="tooltip" data-placement="bottom" title="Producer creation date">
                                        {{ \Carbon\Carbon::parse($producer->created_at)->toFormattedDateString() }}
                                    </small>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="white-box little-min">
                                <h4>{{ __('Still not a member?') }}</h4>
                                {{--<p class="black-54">{{ trans('admin/user.membership_unpaid_link') }}</p>--}}
                                <small>Local Food Nodes is built on a gift based economy.
                                    By donating a supporting membership fee, free of choice, you are part of financing the development of open digital tools, that supports enabling local and independent peoples driven food markets.</small>

                                <a class="bottom-link text-uppercase rc" href="#">{{ __('Membership') }}</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4 class="position-absolute">{{ __('Next pickup') }}</h4>
                                <div class="row h-100">
                                    <div class="col-16 my-auto text-center">
                                        <i class="fa fa-shopping-basket icon-big" aria-hidden="true"></i>
                                        <p class="mt-4">{{ __('You don\'t have any upcoming deliveries') }}</p>
                                        <a class="btn btn-primary mt-3" href="#">{{ __('Find nodes') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4>{{ __('Nodes close to me') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="row">
                        <div class="col-16">
                            <div class="producer-products-list-container">
                                <h4>{{ __('My products') }}</h4>
                                <div class="overflow-scroll h-100">
                                    <div class="producer-products-list">
                                        <ul class="list-unstyled node-list mt-2 list-group">
                                            @foreach($producer->products() as $product)
                                                <a class="my-0 py-2 list-group-item-action" href="/account/producer/{{ $producer->id }}/product/{{ $product->id }}">
                                                    <div class="products-list-image">
                                                        <img src="{{ '/images/shutterstock_436974091.jpg' }}">
                                                    </div>
                                                    <small class="col black-87">{{ $product->name }}</small>
                                                </a>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min height-rmd-auto">
                                <h4>Connected nodes</h4>

                                <ul class="list-unstyled node-list mt-4">
                                    <li>
                                        <div class="row no-gutters">
                                            <div class="col-2">
                                                <i class="fa fa-asterisk icon-green" aria-hidden="true"></i>
                                            </div>
                                            <div class="col">Grönsaksfest -
                                                <small>25 Sep</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row no-gutters">
                                            <div class="col-2">
                                            </div>
                                            <div class="col">Paprikaprovning -
                                                <small>13 Juni</small>
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

