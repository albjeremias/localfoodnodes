{{-- MY PANEL --}}
<li class="nav-item">
    <a class="nav-link black-54" href="/account/user">{{ trans('admin/user-nav.my_panel') }}</a>
</li>

{{-- PRODUCER --}}
@if ($user->producerAdminLinks()->count() > 0)
    <li class="nav-item dropdown">

    @foreach ($user->producerAdminLinks() as $producerAdminLink)
            <a class="nav-link black-54 dropdown-toggle {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id) ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $producerAdminLink->getProducer()->name }}
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/product*') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/products">- {{ trans('admin/user-nav.products') }}</a>
                <a class="dropdown-item {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/deliveries') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/deliveries">- {{ trans('admin/user-nav.deliveries') }}</a>
                <a class="dropdown-item {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/#nodes') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/#nodes">- {{ trans('admin/user-nav.delivery_nodes') }}</a>
                <a class="dropdown-item {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id . '/events') ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/events">- {{ trans('admin/user-nav.events') }}</a>
            </div>
        @endforeach
    </li>

    {{-- CREATE PRODUCT --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}/product/create">{{ trans('admin/user-nav.create_product') }}</a>
    </li>


@elseif ($user->producerAdminLinks()->count() === 0)
    {{-- CREATE PRODUCER --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="/account/producer/create">{{ trans('admin/user-nav.create_producer') }}</a>
    </li>
@endif




@if ($user->nodeAdminLinks()->count() > 0)

    <li class="nav-item dropdown">
        <a class="nav-link black-54 dropdown-toggle" href="#" id="navbarDropdownNodes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ trans('admin/user-nav.node_administration') }}
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdownNodes">
            @foreach ($user->nodeAdminLinks() as $nodeAdminLink)
                <a class="dropdown-item {{ Request::is('account/node/' . $nodeAdminLink->getNode()->id) ? 'active' : '' }}" href="/account/node/{{ $nodeAdminLink->getNode()->id }}">{{ $nodeAdminLink->getNode()->name }}</a>
            @endforeach
        </div>
    </li>
@else
    <li class="nav item"><a href="/account/node/create"><i class="fa fa-plus-circle"></i> {{ trans('admin/user-nav.create_node') }}</a></li>
@endif




{{-- ADMINISTRATION --}}
<li class="nav-item">
    <a class="nav-link black-54" href="/account/user">{{ trans('admin/user-nav.admin') }}</a>
</li>