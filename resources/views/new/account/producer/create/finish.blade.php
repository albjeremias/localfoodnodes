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
                        __('Terms'),
                        __('Create producer'),
                        __('Sales channels'),
                        __('Finish')
                    ]
            ])


        <div class="bg-accent-light-24">
            <div class="container py-5">
                <div class="row py-4 terms_intro text-center">
                    <div class="col-xl-16">
                        <h2>{{ __('Härligt och bra jobbat!') }}</h2>
                        Du har nu ett producentkonto på Local Food Nodes som du kostnadsfritt kan använda fritt för att sälja dina produkter direkt till konsument, helt utan mellanhänder.
                    </div>
                </div>
            </div>
        </div>


        <div class="container py-5">
            <div class="text-center">
                <h2 class=" mb-3">{{ __('Tell the world!') }}</h2>

                <p>
                    Berätta för dina följare att du blivit LFN-producent.
                    Kopiera länken och klistar in där det passar dig.
                </p>

                <div class="d-flex">
                    <div class="p-3 w-75 mx-auto" style="border: #bf360c dashed 1px;">
                        <div class="d-flex">
                            @foreach($producer->images() as $image)
                                <div class="mx-auto mt-1 mb-3" style="width: 50px">
                                    <img class="image w-100" src="{{ $image->url('small') }}">
                                </div>
                            @endforeach
                        </div>
                        <p>
                            {{ __('Whoopa') }},
                            {{ $producer->name }}
                            {{ __('is now registered at Local Food Nodes, the open source platform for prime local food, without any middlemen.
                                    Just great local food, from farmer to locals.
                                    Welcome to visit our farm page at local food nodes  and find out about us, our products and where to we deliver.
                                    #letsgolocal') }}
                        </p>
                        <button class="btn btn-sm btn-outline-secondary">{{ __('Copy link') }}</button>
                    </div>
                </div>

                <h4 class="mt-5 mb-3">{{  __('Choose where you want to go now') }}</h4>
                <a href="/account/producer/{{ $producer->id }}/channels" class="btn btn-secondary">{{ __('Visit your farm page') }}</a>
                <a href="/account/producer/{{ $producer->id }}" class="btn btn-secondary mx-3">{{ __('Dashboard') }}</a>
                <a href="/account/producer/{{ $producer->id }}/product/create" class="btn btn-secondary">{{ __('Create a product') }}</a>
                <div class="text-center">
                    <a href="/account/producer/{{ $producer->id }}/channels" class="btn btn-primary mt-5">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
