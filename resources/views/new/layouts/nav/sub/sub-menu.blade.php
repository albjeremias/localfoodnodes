{{-- EXTEND NAVBAR TO SHOW ACCOUNT NAVBAR --}}



{{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
@foreach ($user->producerAdminLinks() as $producerAdminLink)
    @php
        $active_producer_id = $producerAdminLink->getProducer()->id;
    @endphp
@endforeach

@php
    $node_navbar = [
        ['name' => trans('public/nav.products'),  'link' => '/node/' . (isset($node_slug) ? $node_slug : ''), 'icon' => 'shopping-basket'],
        ['name' => trans('public/nav.calendar'),  'link' => '#', 'icon' => 'calendar'],
        ['name' => trans('public/nav.producers'), 'link' => '#', 'icon' => 'user-circle-o'],
        ['name' => trans('public/nav.images'),    'link' => '#', 'icon' => 'picture-o'],
    ];

    $account_navbar = [
        ['name' => trans('public/nav.dashboard'),  'link' => '/account/user',         'icon' => 'th-large'],
        ['name' => trans('public/nav.my_nodes'),   'link' => '/account/nodes',        'icon' => 'map-marker'],
        ['name' => trans('public/nav.pick_ups'),   'link' => '/account/user/pickups', 'icon' => 'home'],
        ['name' => trans('public/nav.my_profile'), 'link' => '/account/user/edit',    'icon' => 'user'],
    ];

    $producer_navbar = [
        ['name' => trans('public/nav.dashboard'),           'link' => '/account/producer/' . $active_producer_id, 'icon' => 'th-large'],
        ['name' => trans('admin/user-nav.create_product'),  'link' => '/account/producer/' . $active_producer_id . '/product/create', 'icon' => 'map-marker'],
        ['name' => trans('admin/user-nav.products'),        'link' => '/account/producer/' . $active_producer_id . '/product*', 'icon' => 'home'],
        ['name' => trans('admin/user-nav.deliveries'),      'link' => '/account/producer/' . $active_producer_id . '/deliveries', 'icon' => 'user'],
    ];

    if (isset($sub_nav)) :
        switch ($sub_nav) :
            case 'account':
                $active_navbar = $account_navbar;
                break;
            case 'node' :
                $active_navbar = $node_navbar;
                break;
            case 'producer' :
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
