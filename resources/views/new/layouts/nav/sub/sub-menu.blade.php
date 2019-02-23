{{-- EXTEND NAVBAR TO SHOW ACCOUNT NAVBAR --}}

@php
    $node_navbar = [
        ['name' => __('Products'),  'link' => '/node/' . (isset($node_slug) ? $node_slug : ''), 'icon' => 'shopping-basket'],
        ['name' => __('Calendar'),  'link' => '#', 'icon' => 'calendar'],
        ['name' => __('Producers'), 'link' => '#', 'icon' => 'user-circle-o'],
        ['name' => __('Images'),    'link' => '#', 'icon' => 'picture-o'],
    ];

    $account_navbar = [
        ['name' => __('Dashboard'),  'link' => route('account_user'),         'icon' => 'th-large'],
        ['name' => __('My nodes'),   'link' => route('account_user_nodes'),   'icon' => 'map-marker'],
        ['name' => __('Pickups'),    'link' => route('account_user_pickups'), 'icon' => 'home'],
        ['name' => __('My profile'), 'link' => route('account_user_edit'),    'icon' => 'user'],
    ];

    if (isset($producer)):
        $producer_navbar = [
            ['name' => __('Dashboard'),  'link' => route('account_producer', ['producerId' => $producer->id]),            'icon' => 'th-large'],
            ['name' => __('Products'),   'link' => route('account_producer_products', ['producerId' => $producer->id]),   'icon' => 'home'],
            ['name' => __('Deliveries'), 'link' => route('account_producer_deliveries', ['producerId' => $producer->id]), 'icon' => 'user'],
        ];
    endif;

    if (isset($sub_nav)):
        switch ($sub_nav):
            case 'account':
                $active_navbar = $account_navbar;
                break;
            case 'node':
                $active_navbar = $node_navbar;
                break;
            case 'producer':
                $active_navbar = $producer_navbar;
                break;
        endswitch;
    endif;
@endphp

@if (isset($active_navbar))
    <div class="bg-main-primary wc text-uppercase text-center text-lg-left container">
        <ul class="list-inline mt-2 d-flex d-md-block mb-0 sub-nav">
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

@include('new.layouts.nav.sub.explore')
