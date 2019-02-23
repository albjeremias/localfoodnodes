@extends('new.account.layout',
[
    'nav_active'   => 1
])

@section('title', __('Edit Producer'))

@section('content')
    <div class="nms">
        <form action="{{ route('account_producer_update', ['producerId' => $producer->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            @include('new.components.forms.input', [
                'name'        => 'id',
                'type'        => 'hidden',
                'value'       => $producer->id,
                'class'       => '',
                'placeholder' => ''
            ])
            @include('new.account.producer.form', ['progress' => false])

            {{-- <div class="container mb-5">
            <button type="submit" class="btn btn-success">{{ __('Save producer') }}</button>
            @if ($producer->adminLinks()->count() > 1)
                <a href="{{ route('account_producer_leave', ['producerId' => $producer->id]) }}" class="btn btn-warning">{{ __('Leave producer') }}</a>
            @else
                <a href="{{ route('account_producer_delete_confirm', ['producerId' => $producer->id]) }}" class="btn btn-danger">{{ __('Delete producer') }}</a>
            @endif
            </div> --}}
        </form>
    </div>
@endsection
