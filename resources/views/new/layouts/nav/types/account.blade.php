{{-- MY PANEL --}}
<li class="nav-item">
    <a class="nav-link black-54 {{ $nav_active == 0 ? 'nav-acount-active ml-3' : '' }}" href="/account/user">{{ trans('admin/user-nav.consumer') }}</a>
</li>

{{-- PRODUCER --}}
@if ($user->producerAdminLinks()->count() > 0 && $nav_active == 1)
    <li class="nav-item dropdown nav-acount-active">

        @foreach ($user->producerAdminLinks() as $producerAdminLink)
            <a class="nav-link black-54 dropdown-toggle {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id) ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $producerAdminLink->getProducer()->name }}
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">Visit</a>
            </div>
        @endforeach
    </li>

@elseif($user->producerAdminLinks()->count() > 0 && $nav_active != 1)
    <li class="nav-item dropdown">

        @foreach ($user->producerAdminLinks() as $producerAdminLink)
            <a class="nav-link black-54 dropdown-toggle {{ Request::is('account/producer/' . $producerAdminLink->getProducer()->id) ? 'active' : '' }}" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Producent
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">{{ $producerAdminLink->getProducer()->name }}</a>
            </div>
        @endforeach
    </li>
@elseif ($user->producerAdminLinks()->count() === 0)
    {{-- CREATE PRODUCER --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="/account/producer/create">{{ trans('admin/user-nav.create_producer') }}</a>
    </li>
@endif

{{-- NODE --}}
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
    {{-- CREATE NODE --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="/account/node/create">{{ trans('admin/user-nav.create_node') }}</a>
    </li>
@endif




{{-- ADMINISTRATION --}}
<li class="nav-item">
    <a class="nav-link black-54" href="/account/user">{{ trans('admin/user-nav.admin') }}</a>
</li>