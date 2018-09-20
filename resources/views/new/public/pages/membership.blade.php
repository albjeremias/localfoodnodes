@extends('new.layouts.simple-page', [
    'header' => trans('public/pages/membership.header'),
    'sub_header' => trans('public/pages/membership.sub_header'),
    'title'      => trans('public/pages/membership.title'),
    'bg' => 'bg-accent-light-24'
])

@section('title', trans('public/pages/membership.title'))

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                <p>
                    {{ trans('public/pages/membership.body') }}
                </p>
            </div>

            <div class="col-16 offset-0 col-md-6 offset-md-2 offset-lg-1 offset-xl-0">
                <div class="text-center">
                    <div class="my-5 mt-lg-0">
                        @include('new.components.statistics.supporting-members')
                    </div>
                    @include('new.components.statistics.average-fee')
                </div>
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection