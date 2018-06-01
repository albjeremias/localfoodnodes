<?php $viewName = 'search' ?>
@extends('new.public.layout')

@section('title', trans('public/index.title'))

@section('content')
    <div class="container nm">
        @include('new.components.table',
        [
            'th' => ['Typ', 'Namn', 'Avstånd från dig', 'Adress', 'Öppentid'],
            'td' => [],
        ]
        )
    </div>
@endsection
