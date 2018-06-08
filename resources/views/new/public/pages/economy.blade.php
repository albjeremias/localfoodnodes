@extends('new.layouts.simple-page', [
    'header'     => trans('public/economy.header'),
    'sub_header' => trans('public/economy.sub_header'),
    'title'      => trans('public/economy.title'),
    'bg'         => 'bg-accent-light-24'
])

@section('title', trans('public/economy.title'))

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                {{ trans('public/economy.body') }}
            </div>

            <div class="col-16 col-md-6 offset-md-2">
                <div class="my-5 mt-md-0">
                    <h3>INTÄKTER 2017</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection