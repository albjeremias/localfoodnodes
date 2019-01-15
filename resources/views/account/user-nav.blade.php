@if (Auth::user() && Auth::user()->active)
    <div class="user-nav d-none d-lg-block">
        <div class="scrollfix">
            <div class="logo">
                <a href="/">
                    {{-- <img src="/images/nav-logo.png"> --}}
                    Local Food Nodes
                </a>
            </div>

            @include('public.cart')

            <div class="block">
                <ul>
                    <li>
                        <a class="find-nodes {{ Request::is('/') ? 'active' : '' }}" href="/"><i class="fa fa-compass"></i> {{ trans('admin/user-nav.find_nodes') }}</a>
                    </li>
                </ul>
            </div>

            @if ($user->admin)
                <div class="block">
                    <div class="block-header">
                        Site admin
                    </div>
                    <ul class="user">
                        <li>
                            <ul>
                                <li><a class="{{ Request::is('admin/users*') ? 'active' : '' }}" href="/admin/users">- Users</a></li>
                                <li><a class="{{ Request::is('admin/economy/transactions*') ? 'active' : '' }}" href="/admin/economy/transactions">- Transactions</a></li>
                                <li><a class="{{ Request::is('admin/email*') ? 'active' : '' }}" href="/admin/email">- Email</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif

            <div class="block">
                <div class="block-header">
                    {{ trans('admin/user-nav.your_user') }}
                </div>
                <ul class="user">
                    <li>
                        <a class="block-section-header {{ Request::is('account/user') ? 'active' : '' }}" href="/account/user">{{ $user->name }}</a>
                        <ul>
                            <li><a class="{{ Request::is('account/user/pickups*') ? 'active' : '' }}" href="/account/user/pickups">- {{ trans('admin/user-nav.pickups') }}</a></li>
                        </ul>
                    </li>

                    @if ($user->nodes()->count() > 0)
                        <li>
                            <div class="block-section-header">{{ trans('admin/user-nav.nodes_you_follow') }}</div>
                            <ul>
                                @foreach ($user->nodes() as $node)
                                    <li>
                                        <a class="{{ Request::is($node->permalink()->urlWithoutSlash . '*') ? 'active' : '' }}" href="{{ $node->permalink()->url }}">- {{ $node->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="block">
                <div class="block-header">
                    {{ trans('admin/user-nav.node_administration') }}
                </div>
                <ul>
                    @if ($user->nodeAdminLinks()->count() > 0)
                        @foreach ($user->nodeAdminLinks() as $nodeAdminLink)
                            <li>
                                <a class="block-section-header {{ Request::is('account/node/' . $nodeAdminLink->getNode()->id) ? 'active' : '' }}" href="/account/node/{{ $nodeAdminLink->getNode()->id }}">{{ $nodeAdminLink->getNode()->name }}</a>
                                <ul>
                                    <li>
                                        <a class="{{ Request::is('account/node/' . $nodeAdminLink->getNode()->id . '/producers') ? 'active' : '' }}" href="/account/node/{{ $nodeAdminLink->getNode()->id }}/producers">- {{ trans('admin/user-nav.producers') }}</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('account/node/' . $nodeAdminLink->getNode()->id . '/users') ? 'active' : '' }}" href="/account/node/{{ $nodeAdminLink->getNode()->id }}/users">- {{ trans('admin/user-nav.users') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endforeach
                    @endif
                    <li>
                        <a href="/account/node/create"><i class="fa fa-plus-circle"></i> {{ trans('admin/user-nav.create_node') }}</a>
                    </li>
                </ul>
            </div>

            <div class="block">
                <div class="block-header">
                    {{ trans('admin/user-nav.producer_administration') }}
                </div>
                <ul>
                    @if ($user->producerAdminLinks()->count() > 0)
                        @foreach ($user->producerAdminLinks() as $producerAdminLink)
                            <li>
                                <a class="block-section-header {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id) ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">{{ $producerAdminLink->getProducer()->name }}</a>
                                <ul>
                                    <li>
                                        <a class="{{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/product*') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/products">- {{ trans('admin/user-nav.products') }}</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/deliveries') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/deliveries">- {{ trans('admin/user-nav.deliveries') }}</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/#nodes') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/#nodes">- {{ trans('admin/user-nav.delivery_nodes') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/product/create"><i class="fa fa-plus-circle"></i> {{ trans('admin/user-nav.create_product') }}</a>
                            </li>
                        @endforeach
                    @elseif ($user->producerAdminLinks()->count() === 0)
                        <li>
                            <a href="/account/producer/create"><i class="fa fa-plus-circle"></i> {{ trans('admin/user-nav.create_producer') }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="block">
                <div class="block-header"></div>
                <ul>
                    <li><a href="http://faq.localfoodnodes.org">{{ trans('admin/user-nav.faq') }}</a></li>
                    <li><a href="http://guide.localfoodnodes.org">{{ trans('admin/user-nav.guide') }}</a></li>
                    <li><a href="/logout">{{ trans('admin/user-nav.logout') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endif
