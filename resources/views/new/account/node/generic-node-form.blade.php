@extends('new.account.layout',
[
    'bread_type'   => __('Admin'),
    'bread_result' => __('Create node'),
    'nav_active'   => 1
])

@section('title', $node->name ?? __('Create node'))

@section('content')

    <div class="nms">
        @include('new.components.progress',
        [
            'active' => 1,
            'steps'  =>
                [
                    __('Approve terms'),
                    __('Create node'),
                    __('admin/node.n_hdiw_item_3'),
                    __('admin/node.n_hdiw_item_4'),
                ]
        ])


        <div class="container mt-5">
            <div class="row">
                <div class="col-md-9">
                    {{-- Address --}}
                    <div class="form-row">
                        <div class="form-group col-8">
                            @include('new.components.forms.input', [
                                'label' => __('Address'),
                                'name'  => 'address',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => __('Address'),
                                'm_value' => $node->address
                            ])
                        </div>

                        {{-- ZIP --}}
                        <div class="form-group col-8 col-md-4">
                            @include('new.components.forms.input', [
                                'label' => __('Zip code'),
                                'name'  => 'zip',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => __('Zip code'),
                                'm_value' => $node->zip
                            ])
                        </div>

                        {{-- City --}}
                        <div class="form-group col-8 col-md-4">
                            @include('new.components.forms.input', [
                                'label' => __('City'),
                                'name'  => 'city',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => __('City'),
                                'm_value' => $node->city
                            ])
                        </div>
                    </div>

                    <div id="map" style="background-color: grey; height: 400px; width: 100%; margin-bottom: 2rem"></div>

                    {{-- Name --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => __('Node name'),
                            'name'  => 'name',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => __('Node name'),
                            'm_value' => $node->name
                        ])
                    </div>

                    {{-- CALENDAR --}}
                    @include('new.account.node.delivery-settings-form')

                </div>

                <div class="offset-1 col-md-6">

                    <h5 class="mb-3">{{ __('Optional data') }}</h5>

                    {{-- Email --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => __('Email'),
                            'name'  => 'email',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => __('Email'),
                            'm_value' => $node->email
                        ])
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        @include('new.components.forms.textarea', [
                            'label'       => __('Information'),
                            'name'        => 'info',
                            'class'       => 'form-control bb-38 wysiwyg',
                            'rows'        => 3,
                            'placeholder' => __('Information'),
                        ])
                    </div>

                    <div class="form-group">
                        <label class="form-check-label ml-4">
                            <input class="form-check-input" name="is_hidden" type="hidden" value="0" />
                            <input class="form-check-input" name="is_hidden" type="checkbox" value="1" {{ $node->is_hidden == 1 ? 'checked' : '' }} />
                            {{ __('Hide on map') }}
                        </label>
                    </div>

                    {{-- Communication Consumers Link --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => __('Facebook page'),
                            'name'  => 'link_facebook',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => __('https://'),
                            'm_value' => $node->link_facebook
                        ])
                    </div>

                    {{-- Communication Producers Link --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => __('Facebook page for producers'),
                            'name'  => 'link_facebook_producers',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => __('https://'),
                            'm_value' => $node->link_facebook_producers
                        ])
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
