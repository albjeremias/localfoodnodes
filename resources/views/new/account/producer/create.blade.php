@extends('new.account.layout',
[
    'nav_active'   => 1
])

@section('title', __('Create producer'))

@section('content')
    <div class="nms">
        @if (app('request')->input('terms') === "approved")
            <form action="{{ route('account_producer_insert') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('new.account.producer.form')
            </form>
        @else
            @include('new.account.producer.terms')
        @endif
    </div>
@endsection
