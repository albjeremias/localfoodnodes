@extends('new.account.layout',
[
    'nav_title' => trans('admin/user.nav_title'),
    'sub_nav' => 'account',
    'sub_nav_active' => 1
])

<?php
$viewName = 'my-nodes';
$user = Auth::user();
?>

@section('title', 'Mina noder')

@section('content')
    <div class="bg-shell bg-xl-white">
        <div class="container nm">
            <div class="row">
                <div class="d-none d-xl-block col-xl-4">
                    <div class="bg-shell pt-3 pl-4 h-100">
                        @include('new.components.nodes-following')
                    </div>
                </div>

                <div class="col-xl-12 pt-2">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="white-box tiny-min">
                                <h4>{{ trans('admin/user.still_not_member') }}</h4>
                                <p>{{ trans('admin/user.membership_unpaid_link') }}</p>
                                <a class="bottom-left-link" href="#">{{ trans('admin/user.membership') }}</a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="white-box tiny-min">
                                <h4>{{ trans('admin/user.still_not_member') }}</h4>
                                <p>{{ trans('admin/user.membership_unpaid_link') }}</p>
                                <a class="bottom-left-link" href="#">{{ trans('admin/user.membership') }}</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="dropdown my-4 d-flex">
                                <i class="fa fa-sort-amount-desc icon my-auto" aria-hidden="true"></i>

                                <button class="btn btn-info dropdown-toggle text-uppercase"
                                        type="button"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    {{ trans('admin/user.sort_by_node') }}
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">PLACEHOLDER</a>
                                    <a href="#" class="dropdown-item">PLACEHOLDER</a>
                                </div>
                            </div>

                            <div class="col-16 pb-5">
                                @include('new.components.cards.node-lg',
                                [
                                    'name'           => 'Bygdens Saluhall Dalby',
                                    'users'          => 1129,
                                    'producers'      => 41,
                                    'products_count' => 12,
                                    'average_dist'   => '13.5',
                                    'address'        => 'Nybygdsvägen 24, 234 01',
                                    'image'          => '/images/field-1000x680.jpg',
                                    'products'       => [
                                        'Honung', 'Fisk', 'Sylt', 'Gurka', 'Bär', 'Kött', 'Bröd'
                                    ]
                                ])

                                @include('new.components.cards.node-lg',
                                [
                                    'name'           => 'Bygdens Saluhall Dalby',
                                    'users'          => 1129,
                                    'producers'      => 41,
                                    'products_count' => 12,
                                    'average_dist'   => '13.5',
                                    'address'        => 'Nybygdsvägen 24, 234 01',
                                    'image'          => '/images/field-1000x680.jpg',
                                    'products'       => [
                                        'Honung', 'Fisk', 'Sylt', 'Gurka', 'Bär', 'Kött', 'Bröd'
                                    ]
                                ])

                                @include('new.components.cards.node-lg',
                                [
                                    'name'           => 'Bygdens Saluhall Dalby',
                                    'users'          => 1129,
                                    'producers'      => 41,
                                    'products_count' => 12,
                                    'average_dist'   => '13.5',
                                    'address'        => 'Nybygdsvägen 24, 234 01',
                                    'image'          => '/images/field-1000x680.jpg',
                                    'products'       => [
                                        'Honung', 'Fisk', 'Sylt', 'Gurka', 'Bär', 'Kött', 'Bröd'
                                    ]
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

