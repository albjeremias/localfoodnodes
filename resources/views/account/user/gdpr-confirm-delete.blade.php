@extends('account.layout', ['hideMenu' => true])

@section('title', 'Delete account'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ trans('admin/user.confirm_delete') }}</div>
                <div class="card-body">
                    {{ trans('admin/user.confirm_delete_info') }}
                </div>
                <div class="card-footer">
                    <a href="/account/user/edit" class="btn btn-success">{{ trans('admin/user.cancel') }}</button>
                    <a href="/account/user/delete" class="btn btn-danger pull-right">{{ trans('admin/user.delete') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
