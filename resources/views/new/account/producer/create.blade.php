@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer')
])

@section('title', trans('public/register.title_producer'))

@section('content')

    <div class="nms">
        @if (app('request')->input('terms') === "approved")
            <form action="/account/producer/insert" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('new.account.producer.form')
            </form>
        @else
            @include('new.account.producer.terms')
        @endif
    </div>
@endsection
