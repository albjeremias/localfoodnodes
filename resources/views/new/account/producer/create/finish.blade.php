@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer'),
    'nav_active'   => 1
])

@section('title', trans('public/register.title_producer'))

@section('content')
    <div class="nms">
        @include('new.components.progress',
            [
                'active' => 3,
                'steps'  =>
                    [
                        __('Read terms'),
                        __('Create account'),
                        __('Sale channels'),
                        __('Finish')
                    ]
            ])
        <div class="container py-5">
            <h2 class="text-center">{{ __('Good job!') }}</h2>
            <p class="text-center w-50 mx-auto mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium amet consectetur delectus, doloribus eveniet ipsa libero nam neque officia optio quae veritatis voluptatibus. Cumque distinctio dolor ipsam nulla totam?</p>
            länk till gård
            <a href="/account/producer/{{ $producer->id }}" class="btn btn-primary">{{ __('Dashboard') }}</a>
            <a href="/account/producer/{{ $producer->id }}/product/create" class="btn btn-primary">{{ __('Create product') }}</a>
            synlighet på kartan
        </div>
    </div>
@endsection
