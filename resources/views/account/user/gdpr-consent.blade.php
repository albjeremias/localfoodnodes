@extends('account.layout', ['hideMenu' => true])

@section('title', 'GDPR Consent')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ trans('admin/user.gdpr') }}</div>
                    <div class="card-body">
                        <p>{!! trans('public/pages/gdpr.content') !!}</p>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-success" href="/account/user/gdpr">Godkänn GDPR</a>
                        <div class="pull-right">
                            <a class="btn btn-danger" href="/account/user/gdpr/delete/confirm">Ta bort konto</a>
                            <a class="btn btn-danger" href="/logout">Logga ut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
