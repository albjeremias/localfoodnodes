@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <div class="nav">
                        <a class="nav-link" href="/admin/email/user/activation">User activation</a>
                        <a class="nav-link" href="/admin/email/user/reset-password">Password reset</a>
                        <a class="nav-link" href="/admin/email/order/producer">Order producer</a>
                        <a class="nav-link" href="/admin/email/order/customer">Order consumer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
