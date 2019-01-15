@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <form id="user-edit-form" action="/account/user/update" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">{{ trans('admin/user.edit_information') }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label" for="name">
                                {{ trans('admin/user.name') }}
                                @if ($errors->has('name'))
                                    <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('admin/user.name') }}" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="email">
                                {{ trans('admin/user.email') }}
                                @if ($errors->has('email'))
                                    <div class="badge badge-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="{{ trans('admin/user.email') }}" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="phone">
                                {{ trans('admin/user.phone') }}
                                @if ($errors->has('phone'))
                                    <div class="badge badge-danger">{{ $errors->first('phone') }}</div>
                                @endif
                            </label>
                            <input type="phone" name="phone" class="form-control" id="phone" placeholder="{{ trans('admin/user.phone') }}" value="{{ $user->phone }}">
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-lg-4">
                                <label class="form-control-label" for="address">{{ trans('admin/user.address') }}</label>
                                <input type="text" name="address" class="form-control" id="address" placeholder="{{ trans('admin/user.address') }}" value="{{ $user->address }}">
                            </div>
                            <div class="form-group col-12 col-lg-4">
                                <label class="form-control-label" for="zip">{{ trans('admin/user.zip') }}</label>
                                <input type="text" name="zip" class="form-control" id="zip" placeholder="{{ trans('admin/user.zip') }}" value="{{ $user->zip }}">
                            </div>
                            <div class="form-group col-12 col-lg-4">
                                <label class="form-control-label" for="city">{{ trans('admin/user.city') }}</label>
                                <input type="text" name="city" class="form-control" id="city" placeholder="{{ trans('admin/user.city') }}" value="{{ $user->city }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="language">{{ trans('admin/user.site_lang') }}</label>
                            <select name="language" id="language" class="form-control">
                                @foreach (config('app.locales') as $langCode => $language)
                                    <option value="{{ $langCode }}" {{ $langCode === $user->language ? 'selected' : '' }}>{{ $language }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="currency">{{ trans('admin/user.currency') }}</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="">{{ trans('admin/user.select_currency') }}</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->currency }}" {{ $currency->currency === $user->currency ? 'selected' : '' }}>{{ $currency->currency }} - {{ $currency->label }}</option>
                                @endforeach
                            </select>
                        </div>

                         <p>
                            {!! trans('admin/user.gdpr_consent_date', ['date' => $user->gdprConsent()->created_at]) !!}
                         </p>
                    </div>
                </div>

                {{-- @include('account.image-card', [
                    'images' => $user->images(),
                    'deleteUrl' => '/account/image/{imageId}/delete',
                    'limit' => 1,
                ]) --}}

                <div class="card">
                    <div class="card-header">Membership payments</div>
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

        @component('account.form-control-bar')
            <button type="submit" form="user-edit-form" class="btn btn-success">{{ trans('admin/user.save_user') }}</button>
            <a href="/account/user/delete/confirm" class="btn btn-danger">{{ trans('admin/user.delete_user') }}</a>
        @endcomponent
    </form>
@endsection
