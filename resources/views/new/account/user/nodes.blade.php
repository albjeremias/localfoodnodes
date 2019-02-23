@extends('new.account.layout',
[
    'sub_nav' => 'account',
    'nav_active' => 0,
    'sub_nav_active' => 1
])

@section('title', 'Mina noder')

@section('content')
    <div class="bg-shell bg-xl-white">
        <div class="container nm">
            <div class="row">
                <div class="d-none d-xl-block col-xl-4">
                    <div class="bg-shell pt-3 pl-4 h-100">
                        @include('new.components.nodes-following', ['nodes' => $user->nodes()])
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
                                @foreach($user->nodes() as $node)
                                    @include('new.components.cards.node-lg', [
                                        'name'           => $node->name,
                                        'users'          => $node->userLinks()->count(),
                                        'producers'      => $node->producerLinks()->count(),
                                        'products_count' => $node->products()->count(),
                                        'average_dist'   => '13.5',
                                        'address'        => $node->address . ', ' . $node->zip,
                                        'image'          => isset($node->images()[0]) ? $node->images()[0]->url('small') : false,
                                        'products'       => [
                                            'Honung', 'Fisk', 'Sylt', 'Gurka', 'Bär', 'Kött', 'Bröd'
                                        ]
                                    ])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

