{{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
@foreach ($user->producerAdminLinks() as $producerAdminLink)
    @php
        $active_producer_name = $producerAdminLink->getProducer()->name;
    @endphp
@endforeach

{{-- MY PANEL --}}
<li class="nav-item">
    <a class="nav-link black-54 {{ $nav_active == 0 ? 'nav-acount-active ml-3' : '' }}" href="/account/user">{{ trans('admin/user-nav.consumer') }}</a>
</li>

{{-- PRODUCER --}}
@if ($user->producerAdminLinks()->count() > 0 && $nav_active && 1)
    <li class="nav-item dropdown nav-acount-active">

            <a class="nav-link black-54 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $active_producer_name }}
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                @foreach ($user->producerAdminLinks() as $producerAdminLink)
                    <a class="dropdown-item" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">{{ $producerAdminLink->getProducer()->name }}</a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/account/producer/create">{{ trans('admin/user-nav.create_producer') }}</a>

            </div>
    </li>

@elseif($user->producerAdminLinks()->count() > 0 && $nav_active != 1)
    <li class="nav-item dropdown">
        <a class="nav-link black-54 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Producent
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

            @foreach ($user->producerAdminLinks() as $producerAdminLink)
                <a class="dropdown-item" href="/account/producer/{{ $producerAdminLink->getProducer()->id }}">{{ $producerAdminLink->getProducer()->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/account/producer/create">{{ trans('admin/user-nav.create_producer') }}</a>

        </div>

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