@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if (!$user->active)
                                        <a href="/admin/users/{{ $user->id }}/activate" class="btn btn-sm btn-secondary">Activate</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
