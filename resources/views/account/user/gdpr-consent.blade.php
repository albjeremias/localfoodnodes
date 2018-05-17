@extends('account.layout', ['hideMenu' => true])

@section('title', 'GDPR Consent')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ trans('admin/user.gdpr') }}</div>
                    <div class="card-body body-text">
                        {!! trans('public/pages/gdpr.content') !!}
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-success" href="/account/user/gdpr">{{ trans('admin/user.gdpr_consent') }}</a>
                        <div class="pull-right">
                            <a class="btn btn-danger" href="/account/user/gdpr/delete/confirm">{{ trans('admin/user.delete_user') }}</a>
                            <a class="btn btn-danger" href="/logout">{{ trans('admin/user-nav.logout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
