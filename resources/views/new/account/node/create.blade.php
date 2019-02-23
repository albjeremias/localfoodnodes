@extends('new.account.layout',
[
    'nav_active'   => 1
])

@section('title', __('Create node'))

@section('content')

    <div class="nms">
        @if ($approved === true || app('request')->input('terms') === "approved")
            <form action="/account/producer/insert" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('new.account.node.generic-node-form')
                <button type="submit" class="btn btn-secondary mt-3 float-right">{{ trans('admin/producer.save_producer') }}</button>
            </form>
        @else
            @include('new.account.node.terms')
        @endif
    </div>
@endsection
