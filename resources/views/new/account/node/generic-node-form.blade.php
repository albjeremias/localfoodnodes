@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer'),
    'nav_active'   => 1
])

@section('title', trans('public/register.title_producer'))

@section('content')

    <div class="nms">
        @include('new.components.progress',
        [
            'active' => 1,
            'steps'  =>
                [
                    trans('admin/node.n_hdiw_item_1'),
                    trans('admin/node.n_hdiw_item_2'),
                    trans('admin/node.n_hdiw_item_3'),
                    trans('admin/node.n_hdiw_item_4'),
                ]
        ])


        <div class="container mt-5">
            <div class="row">
                <div class="col-md-9">
                    {{-- Address --}}
                    <div class="form-row">
                        <div class="form-group col-8">
                            @include('new.components.forms.input', [
                                'label' => trans('admin/node.address'),
                                'name'  => 'address',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => trans('admin/node.address'),
                                'm_value' => $node->address
                            ])
                        </div>

                        {{-- ZIP --}}
                        <div class="form-group col-8 col-md-4">
                            @include('new.components.forms.input', [
                                'label' => trans('admin/node.zip'),
                                'name'  => 'zip',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => trans('admin/node.zip'),
                                'm_value' => $node->zip
                            ])
                        </div>

                        {{-- City --}}
                        <div class="form-group col-8 col-md-4">
                            @include('new.components.forms.input', [
                                'label' => trans('admin/node.city'),
                                'name'  => 'city',
                                'type'  => 'text',
                                'class' => 'form-control',
                                'placeholder' => trans('admin/node.city'),
                                'm_value' => $node->city
                            ])
                        </div>
                    </div>

                    <div id="map" style="background-color: grey; height: 400px; width: 100%; margin-bottom: 2rem"></div>

                    {{-- Name --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => trans('admin/node.name_your_node'),
                            'name'  => 'name',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => trans('admin/node.name_your_node'),
                            'm_value' => $node->name
                        ])
                    </div>

                    {{-- CALENDAR --}}
                    @include('new.account.node.delivery-settings-form')

                </div>

                <div class="offset-1 col-md-6">

                    <h5 class="mb-3">{{ trans('admin/node.optional_data') }}</h5>

                    {{-- Email --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => trans('admin/node.email'),
                            'name'  => 'email',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => trans('admin/node.email'),
                            'm_value' => $node->email
                        ])
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        @include('new.components.forms.textarea', [
                            'label'       => trans('admin/node.information'),
                            'name'        => 'info',
                            'class'       => 'form-control bb-38 wysiwyg',
                            'rows'        => 3,
                            'placeholder' => trans('admin/node.information'),
                        ])
                    </div>

                    <div class="form-group">
                        <label class="form-check-label ml-4">
                            <input class="form-check-input" name="is_hidden" type="hidden" value="0" />
                            <input class="form-check-input" name="is_hidden" type="checkbox" value="1" {{ $node->is_hidden == 1 ? 'checked' : '' }} />
                            {{ trans('admin/node.hide_from_map') }}
                        </label>
                    </div>

                    {{-- Communication Consumers Link --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => trans('admin/node.facebook_page'),
                            'name'  => 'link_facebook',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => trans('admin/node.facebook_page_placeholder'),
                            'm_value' => $node->link_facebook
                        ])
                    </div>

                    {{-- Communication Producers Link --}}
                    <div class="form-group">
                        @include('new.components.forms.input', [
                            'label' => trans('admin/node.facebook_page_producers'),
                            'name'  => 'link_facebook_producers',
                            'type'  => 'text',
                            'class' => 'form-control',
                            'placeholder' => trans('admin/node.facebook_page_placeholder'),
                            'm_value' => $node->link_facebook_producers
                        ])
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
