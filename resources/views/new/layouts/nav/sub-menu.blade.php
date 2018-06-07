{{-- EXTEND NAVBAR TO SHOW ACCOUNT NAVBAR --}}

@php
    $node_navbar = [
        ['name' => 'Produkter',   'link' => '/node/' . (isset($node_slug) ? $node_slug : ''), 'icon' => 'shopping-basket'],
        ['name' => 'Kalender',    'link' => '#', 'icon' => 'calendar'],
        ['name' => 'Producenter', 'link' => '#', 'icon' => 'user-circle-o'],
        ['name' => 'Bilder',      'link' => '#', 'icon' => 'picture-o'],
    ];

    $account_navbar = [
        ['name' => 'Dashboard',   'link' => '/account/user',  'icon' => 'th-large'],
        ['name' => 'Mina Noder',  'link' => '/account/nodes', 'icon' => 'map-marker'],
        ['name' => 'Utlämningar', 'link' => '#',              'icon' => 'home'],
        ['name' => 'Evenemang',   'link' => '#',              'icon' => 'calendar'],
        ['name' => 'Min Profil',  'link' => '#',              'icon' => 'user'],
    ];

    if (isset($sub_nav)) :
        switch ($sub_nav) :
            case 'account':
                $active_navbar = $account_navbar;
                break;
            case 'node' :
                $active_navbar = $node_navbar;
                break;
        endswitch;
    endif;
@endphp

@if (isset($sub_nav))
    <div class="bg-main-primary wc text-uppercase sub-nav text-center text-lg-left">
        <ul class="list-inline mt-2 d-flex d-md-block mb-0">
            @foreach($active_navbar as $nav_item)
                <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == $loop->index ? 'sub-nav-active' : '' }} pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-3">
                    <a class="px-md-3 wc" href="{{ $nav_item['link'] }}">
                        <span class="d-none d-md-inline">{{ $nav_item['name'] }}</span>
                        <i class="fa fa-{{ $nav_item['icon'] }} d-md-none icon w-100" aria-hidden="true"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif