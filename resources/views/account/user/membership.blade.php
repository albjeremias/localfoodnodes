@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <div class="row">
        <div class="col-xs-12 col-lg-8">
            <div class="card mb-5">
                <div class="card-header">{{ trans('admin/user.membership') }}</div>
                <div class="card-body">
                    {!! trans('public/pages/membership.body') !!}
                </div>

                @include('account.user.membership-form')
            </div>

            <div class="card">
                <div class="card-header">History</div>
                <div class="card-body">
                    @if ($user->membershipPayments()->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/user.date') }}</th>
                                    <th>{{ trans('admin/user.fee') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->membershipPayments() as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at }}</td>
                                        <td>{{ $payment->amount }} {{ $payment->currency }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        {{ trans('admin/user.membership_no_history') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
