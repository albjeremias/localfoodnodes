@extends('new.layouts.simple-page', [
    'header' => trans('public/pages/find-out-more.subheader_1'),
    'sub_header' => '#LETSGETSOCIAL',
    'title'      => trans('public/pages/find-out-more.title'),
    'bg' => 'bg-accent-light-24'
])

@section('title', trans('public/pages/find-out-more.title'))

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                {!! trans('public/pages/find-out-more.body') !!}
            </div>

            <div class="col-16 col-md-6 offset-md-2">
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection