@extends('new.account.layout',
[
    'bread_type'   => 'Admin',
    'bread_result' => 'Skapa Producent'
])

@section('title', join(array_keys($breadcrumbs), ' - '))

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
