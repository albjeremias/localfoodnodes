@extends('new.account.layout',
[
    'nav_title' => trans('admin/user.nav_title'),
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
                                <h4>{{ trans('admin/user.profile_info') }}</h4>
                                <ul class="list-unstyled list-p">
                                    <li>{{ Auth::user()->name }}</li>
                                    <li class="black-54">{{ Auth::user()->email }}</li>
                                </ul>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <h3 class="m-0">1129</h3>
                                        <small>{{ trans('admin/user.followed_nodes') }}</small>
                                    </div>

                                    <div class="col-md-4">
                                        <h3 class="m-0">41</h3>
                                        <small>{{ trans('admin/user.producers') }}</small>
                                    </div>

                                    <div class="col pl-md-5">
                                        <h3 class="m-0">13.5 km</h3>
                                        <small>{{ trans('admin/user.average_distance') }}</small>
                                    </div>
                                </div>

                                <a class="bottom-link text-uppercase rc" href="#">{{ trans('admin/user.edit_profile') }}</a>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="white-box little-min">
                                <h4>{{ trans('admin/user.still_not_member') }}</h4>
                                <p class="black-54">{{ trans('admin/user.membership_unpaid_link') }}</p>

                                <a class="bottom-link text-uppercase rc" href="#">{{ trans('admin/user.membership') }}</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4 class="position-absolute">{{ trans('admin/user.next_pickup') }}</h4>
                                <div class="row h-100">
                                    <div class="col-16 my-auto text-center">
                                        <i class="fa fa-shopping-basket icon-big" aria-hidden="true"></i>
                                        <p class="mt-4">{{ trans('admin/user.no_deliveries') }}</p>
                                        <a class="btn btn-primary mt-3" href="#">{{ trans('admin/user.find_deliveries') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4>{{ trans('admin/user.close_delivery_spots') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="row">
                        <div class="col-16">
                            <div class="white-box big-min height-rmd-auto">
                                @include('new.components.nodes-following')
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min height-rmd-auto">
                                <h4>{{ trans('admin/user.events') }}</h4>

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

