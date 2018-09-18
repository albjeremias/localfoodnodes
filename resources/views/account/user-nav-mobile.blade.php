@if (Auth::user() && Auth::user()->active)
    <div class="container-fluid d-lg-none mb-5">
        <div class="row">
            <nav class="navbar navbar-light user-nav-responsive">
                <a class="navbar-brand" href="/">
                    {{-- <img src="/images/nav-logo-dark.png"> --}}
                    <span>Local Food Nodes</span>
                </a>

                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="/account/user">{{ $user->name }}</a>
                        </li>

                        @if (Auth::user() && Auth::user()->cartItems()->count() > 0)
                            <li class="nav-item">
                                <a href="/checkout">{{ trans('admin/user-nav.cart_and_checkout') }}</a>
                            </li>
                        @endif

                        <div class="nav-item nav-item-divider"></div>

                        @if ($user->nodeAdminLinks()->count() > 0)
                            @foreach ($user->nodeAdminLinks() as $nodeAdminLink)
                                <li class="nav-item">
                                    <a href="/account/node/{{ $nodeAdminLink->getNode()->id }}">
                                        {{ $nodeAdminLink->getNode()->name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a href="/account/node/create">
                                    {{ trans('admin/user-nav.create_node') }}
                                </a>
                            </li>
                        @endif

                        @if ($user->producerAdminLinks()->count() > 0)
                            @foreach ($user->producerAdminLinks() as $producerAdminLink)
                                <li class="nav-item">
                                    <a href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">
                                        {{ $producerAdminLink->getProducer()->name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a href="/account/producer/create">
                                    {{ trans('admin/user-nav.create_producer') }}
                                </a>
                            </li>
                        @endif

                        <div class="nav-item nav-item-divider"></div>

                        <li class="nav-item"><a href="/logout">{{ trans('admin/user-nav.logout') }}</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
@endif
