@extends('new.account.layout',
[
    'nav_title' => __('My profile'),
    'sub_nav' => 'account',
    'nav_active' => 0,
    'sub_nav_active' => 3
])

@section('title', trans('public/nav.my_profile'))

@section('content')
    <div class="container nm pt-2">
        <form id="user-edit-form" action="{{ route('account_user_update') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row my-5">

                <div class="col-md-8">
                    {{-- Name --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => __('Name'),
                            'label_cap'   => true,
                            'name'        => 'name',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('Name'),
                            'm_value'       => $user->name
                        ])
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => __('Email'),
                            'label_cap'   => true,
                            'name'        => 'email',
                            'type'        => 'email',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('Email'),
                            'm_value'       => $user->email
                        ])
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => __('Phone'),
                            'label_cap'   => true,
                            'name'        => 'phone',
                            'type'        => 'phone',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('Phone'),
                            'm_value'       => $user->phone
                        ])
                    </div>

                    {{-- Address --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label'       => __('Address'),
                            'label_cap'   => true,
                            'name'        => 'address',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('Address'),
                            'm_value'       => $user->address
                        ])
                    </div>

                    <div class="form-row">
                    {{-- ZIP --}}
                    <div class="form-group col">
                        @include('new.components.forms.input', [
                            'label'       => __('Zip'),
                            'label_cap'   => true,
                            'name'        => 'zip',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('Zip'),
                            'm_value'       => $user->zip
                        ])
                    </div>

                    {{-- City --}}
                    <div class="form-group col">
                        @include('new.components.forms.input', [
                            'label'       => __('City'),
                            'label_cap'   => true,
                            'name'        => 'city',
                            'type'        => 'text',
                            'class'       => 'form-control bb-38 bc',
                            'placeholder' => __('City'),
                            'm_value'       => $user->city
                        ])
                    </div>
                    </div>

                    {{-- Language --}}
                    <div class="form-group">
                        @include('new.components.forms.dropdown', [
                            'label'       => __('Site lang'),
                            'name'        => 'language',
                            'class'       => 'custom-select bb-38 bc',
                            'options'     => config('app.locales'),
                            'value'       => true,
                            'val_key'     => true,
                        ])
                    </div>

                    {{-- GDPR Concent --}}
                    <p>{!! __('GDPR consent date', ['date' => $user->gdprConsent()->created_at]) !!}</p>
                </div>

                <div class="col-md-6 offset-md-2">

                    {{-- Images --}}
                    <h4>Images</h4>
                    @include('new.components.upload.images', [
                        'entityType' => 'user',
                        'entityId' => $user->id ?: null,
                        'images' => $user->images(),
                        'limit' => 1,
                    ])

                    <div class="mt-5">
                        {{-- Save --}}
                        <button type="submit" form="user-edit-form" class="btn btn-success">{{ __('Save user') }}</button>

                        {{-- Delete --}}
                        <a href="{{ route('account_user_delete_confirm') }}" class="btn btn-danger float-right">{{ __('Delete user') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

