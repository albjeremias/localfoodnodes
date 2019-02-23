{{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
    @php
        $active_producer_name = $user->producerAdminLinks()[0]->getProducer()->name;
    @endphp

{{-- MY PANEL --}}
<li class="nav-item">
    <a class="nav-link black-54 {{ $nav_active == 0 ? 'nav-account-active ml-3' : '' }}" href="/account/user">{{ Auth::user()->name }}</a>
</li>

{{-- PRODUCER --}}
@if ($user->producerAdminLinks()->count() > 0 && $nav_active == 1)
    <li class="nav-item dropdown nav-account-active">
        <a class="nav-link black-54 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $active_producer_name }}
        </a>
        <div class="dropdown-menu box-shadow" aria-labelledby="navbarDropdown">

            @foreach ($user->producerAdminLinks() as $producerAdminLink)
                <a class="dropdown-item" href="{{ route('account_producer', ['producerId' => $producerAdminLink->getProducer()->id ]) }}">{{ $producerAdminLink->getProducer()->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('account_producer_create') }}">{{ __('Create producer') }}</a>
        </div>
    </li>
@elseif($user->producerAdminLinks()->count() > 0 && $nav_active != 1)
    <li class="nav-item dropdown">
        <a class="nav-link black-54 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Producent
        </a>
        <div class="dropdown-menu box-shadow" aria-labelledby="navbarDropdown">

            @foreach ($user->producerAdminLinks() as $producerAdminLink)
                <a class="dropdown-item" href="{{ route('account_producer', ['producerId' => $producerAdminLink->getProducer()->id ]) }}">{{ $producerAdminLink->getProducer()->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('account_producer_create') }}">{{ __('Create producer') }}</a>

        </div>

    </li>
@elseif ($user->producerAdminLinks()->count() === 0)
    {{-- CREATE PRODUCER --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="{{ route('account_producer_create') }}">{{ __('Create producer') }}</a>
    </li>
@endif

{{-- NODE --}}
@if ($user->nodeAdminLinks()->count() > 0 && $nav_active == 2)
    <li class="nav-item dropdown nav-account-active">
        <a class="nav-link black-54 dropdown-toggle" href="#" id="navbarDropdownNodes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('Node administration') }}
        </a>
        <div class="dropdown-menu box-shadow" aria-labelledby="navbarDropdownNodes">
            @foreach ($user->nodeAdminLinks() as $nodeAdminLink)
                <a class="dropdown-item {{ Request::is('account/node/' . $nodeAdminLink->getNode()->id) ? 'active' : '' }}" href="/account/node/{{ $nodeAdminLink->getNode()->id }}">{{ $nodeAdminLink->getNode()->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('account_node_create') }}">{{ __('Create node') }}</a>
        </div>
    </li>
@elseif ($user->nodeAdminLinks()->count() > 0 && $nav_active != 2)
    <li class="nav-item dropdown">
        <a class="nav-link black-54 dropdown-toggle" href="#" id="navbarDropdownNodes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('Node administration') }}
        </a>
        <div class="dropdown-menu box-shadow" aria-labelledby="navbarDropdownNodes">
            @foreach ($user->nodeAdminLinks() as $nodeAdminLink)
                <a class="dropdown-item {{ Request::is('account/node/' . $nodeAdminLink->getNode()->id) ? 'active' : '' }}" href="{{ route('account_node', ['nodeId' => $nodeAdminLink->getNode()->id]) }}">{{ $nodeAdminLink->getNode()->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('account_node_create') }}">{{ __('Create node') }}</a>
        </div>
    </li>
@else
    {{-- CREATE NODE --}}
    <li class="nav-item">
        <a class="nav-link black-54" href="{{ route('account_node_create') }}">{{ __('Create node') }}</a>
    </li>
@endif

{{-- NODES --}}
<li class="nav-item">
    <a class="nav-link black-54" href="/explore">{{ __('Find nodes') }}</a>
</li>