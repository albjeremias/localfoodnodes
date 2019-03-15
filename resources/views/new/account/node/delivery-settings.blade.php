@extends('new.account.layout',
[
    'nav_active'   => 1,
    'script' => 'pickup-dates'
])

@section('title', $node->name ?? __('Create node'))

@section('content')

    <div id="pickup-dates" class="nms">
        @include('new.components.progress',
        [
            'active' => 2,
            'steps'  =>
                [
                    __('Terms'),
                    __('Create'),
                    __('Pickup dates'),
                    __('Invite'),
                    __('Finish'),
                ]
        ])

        <pickup-dates></pickup-dates>
    </div>
@endsection