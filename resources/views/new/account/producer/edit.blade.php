@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer')
])

@section('title', trans('public/register.title_producer'))

@section('content')
    <div class="nms">
        <form action="/account/producer/{{ $producer->id }}/update" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            @include('new.components.forms.input', [
                'name'        => 'id',
                'type'        => 'hidden',
                'value'       => $producer->id,
                'class'       => '',
                'placeholder' => ''
            ])
            @include('new.account.producer.form')

            <div class="container mb-5">
            <button type="submit" class="btn btn-success">{{ trans('admin/producer.save_producer') }}</button>
            @if ($producer->adminLinks()->count() > 1)
                <a href="/account/producer/{{ $producer->id }}/leave" class="btn btn-warning">{{ trans('admin/producer.leave_producer') }}</a>
            @else
                <a href="/account/producer/{{ $producer->id }}/delete/confirm" class="btn btn-danger">{{ trans('admin/producer.delete_producer') }}</a>
            @endif
            </div>
        </form>
    </div>
@endsection
