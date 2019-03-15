@extends('new.account.layout',
[
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
                    __('Terms'),
                    __('Create'),
                    __('Pickup dates'),
                    __('Invite'),
                    __('Finish'),
                ]
        ])

        <div class="container mt-5">
            <h2>{{ __('Node information') }}</h2>

            <div class="row my-4">
                <div class="col-md-9">

                    <div class="form-row mt-4">
                        <div class="form-group col-md-8">
                            @include('new.components.forms.input', [
                                'label' => __('Node name'),
                                'name'  => 'name',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => __('Name'),
                                'm_value' => $node->name ?? ''
                            ])
                        </div>

                        {{-- Email --}}
                        <div class="form-group col-md-8">
                            @include('new.components.forms.input', [
                                'label' => __('Email'),
                                'name'  => 'email',
                                'type'  => 'email',
                                'class' => 'form-control',
                                'placeholder' => __('Email'),
                                'm_value' => $node->email ?? ''
                            ])
                        </div>
                    </div>

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

                        {{-- Description --}}
                        <div class="form-group mt-2 col-16">
                            @include('new.components.forms.textarea', [
                                'label'       => __('Information'),
                                'name'        => 'info',
                                'class'       => 'form-control bb-38 wysiwyg',
                                'rows'        => 13,
                                'placeholder' => __('Information'),
                            ])
                        </div>

                    </div>

                </div>

                <div class="offset-1 col-md-6">

                    {{-- Images --}}
                    <div class="form-group my-4">
                        <label>{{ __('Images') }}</label>
                        @include('new.components.upload.images', [
                            'entityType' => 'producer',
                            'entityId' => $node->id ?: null,
                            'images' => $node->images(),
                            'limit' => 4,
                        ])
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-check-label ml-4">
                            <input class="form-check-input" name="is_hidden" type="hidden" value="0" />
                            <input class="form-check-input" name="is_hidden" type="checkbox" value="1" {{ $node->is_hidden == 1 ? 'checked' : '' }} />
                            {{ __('Hide on map') }}
                        </label>
                    </div>

                    <div id="map" style="background-color: grey; height: 250px; width: 100%; margin-bottom: 2rem"></div>


                    {{-- Communication Consumers Link --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => __('Communication link (e.g. Facebook, Slack)'),
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
                            'label' => __('Producer communication link (e.g. Facebook, Slack)'),
                            'name'  => 'link_facebook_producers',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => __('https://'),
                            'm_value' => $node->link_facebook_producers
                        ])
                    </div>
                </div>
                <div class="d-flex w-100">
                    <button type="submit" class="btn btn-primary">{{  __('Back') }}</button>
                    @include('new.components.forms.submit')
                </div>
            </div>
        </div>
    </div>
@endsection
