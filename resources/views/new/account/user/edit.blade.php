@extends('new.account.layout',
[
    'nav_title' => trans('admin/user.nav_title'),
    'sub_nav' => 'account',
    'nav_active' => 0,
    'sub_nav_active' => 3
])

@section('title', trans('public/nav.my_profile'))

@section('content')
    <div class="container nm pt-2">
        <form id="user-edit-form" action="/account/user/update" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row my-5">

                <div class="col-md-8">
                    {{-- Name --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.name'),
                            'label_cap'   => true,
                            'name'        => 'name',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.name'),
                            'value'       => $user->name
                        ])
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.email'),
                            'label_cap'   => true,
                            'name'        => 'email',
                            'type'        => 'email',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.email'),
                            'value'       => $user->email
                        ])
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.phone'),
                            'label_cap'   => true,
                            'name'        => 'phone',
                            'type'        => 'phone',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.phone'),
                            'value'       => $user->phone
                        ])
                    </div>

                    {{-- Address --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.address'),
                            'label_cap'   => true,
                            'name'        => 'address',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.address'),
                            'value'       => $user->address
                        ])
                    </div>

                    <div class="form-row">
                    {{-- ZIP --}}
                    <div class="form-group col">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.zip'),
                            'label_cap'   => true,
                            'name'        => 'zip',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.zip'),
                            'value'       => $user->zip
                        ])
                    </div>

                    {{-- City --}}
                    <div class="form-group col">
                        @include('new.components.forms.input', [
                            'label'       => trans('admin/user.city'),
                            'label_cap'   => true,
                            'name'        => 'city',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => trans('admin/user.city'),
                            'value'       => $user->city
                        ])
                    </div>
                    </div>

                    {{-- Language --}}
                    <div class="form-group">
                        @include('new.components.forms.dropdown', [
                            'label'       => trans('admin/user.site_lang'),
                            'name'        => 'language',
                            'class'       => 'custom-select bb-38 bc',
                            'options'     => config('app.locales'),
                            'value'       => true,
                            'val_key'     => true,
                        ])
                    </div>

                    {{-- GDPR Concent --}}
                    <p>{!! trans('admin/user.gdpr_consent_date', ['date' => $user->gdprConsent()->created_at]) !!}</p>
                </div>

                <div class="col-md-6 offset-md-2">

                    {{-- Images --}}
                    @include('account.image-card', [
                        'images' => $user->images(),
                        'deleteUrl' => '/account/image/{imageId}/delete',
                        'limit' => 1,
                    ])

                    <div class="mt-5">
                        {{-- Save --}}
                        <button type="submit" form="user-edit-form" class="btn btn-success">{{ trans('admin/user.save_user') }}</button>

                        {{-- Delete --}}
                        <a href="/account/user/delete/confirm" class="btn btn-danger float-right">{{ trans('admin/user.delete_user') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

