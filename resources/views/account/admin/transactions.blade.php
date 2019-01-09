@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <div id="admin-transaction-list">
       <admin-transaction-list></admin-transaction-list>
    </div>
    <script src="{{ mix('/js/admin-transaction-list.js') }}"></script>
@endsection
