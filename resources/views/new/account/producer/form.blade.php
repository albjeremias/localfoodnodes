@include('new.components.progress',
[
    'active' => 1,
    'steps'  =>
        [
            __('Read terms'),
            __('Create account'),
            __('Sale channels'),
            __('Create products')
        ]
])

<div class="container my-5">
    <h2>{{ __('Producer info') }}</h2>

    <div class="row mt-4">
        <div class="col-md-9">
            <h4>{{ __('Producer info') }}</h4>

            {{-- Farm/Business name --}}
            <div class="form-row mt-4">
                <div class="form-group col-md-8">
                    @include('new.components.forms.input', [
                        'label' => __('Farm name'),
                        'name'  => 'name',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => __('Name'),
                        'm_value' => $producer->name ?? ''
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
                        'm_value' => $producer->email ?? ''
                    ])
                </div>

                {{-- Address --}}
                <div class="form-group col-md-8">
                    @include('new.components.forms.input', [
                        'label' => __('Address'),
                        'name'  => 'address',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => __('Address'),
                        'm_value' => $producer->address ?? ''
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
                        'm_value' => $producer->zip ?? ''
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
                        'm_value' => $producer->city ?? ''
                    ])
                </div>

                {{-- Info --}}
                <div class="form-group col-md-16">
                    @include('new.components.forms.textarea', [
                        'label' => __('Describe your farm'),
                        'name'  => 'info',
                        'class' => 'form-control wysiwyg',
                        'rows'  => 7,
                        'old'   => $producer->info,
                        'm_value' => $producer->info ?? ''
                    ])
                </div>

                {{-- Currency --}}
                <div class="form-group col-md-7">
                    <h4>{{ __('Payment info') }}</h4>

                    @include('new.components.forms.dropdown', [
                        'label'       => __('Currency'),
                        'name'        => 'currency',
                        'class'       => 'bb-38 form-control',
                        'placeholder' => __('Choose currency'),
                        'options'     => $currencies, // Todo: use correct currency source
                        'value'       => false
                        // Add set value
                    ])
                </div>

                {{-- Payment Info --}}
                <div class="form-group col-16">
                    @include('new.components.forms.input', [
                        'label' => __('Payment info'),
                        'name'  => 'payment_info',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => __('Payment info for all orders'),
                        'm_value' => $producer->payment_info ?? ''
                    ])
                </div>
            </div>
        </div>

        <div class="col-md-6 offset-md-1">
            <div class="form-group mb-5">
            <h4>{{ __('Images') }}</h4>
                @include('new.components.upload.images', [
                    'entityType' => 'producer',
                    'entityId' => $producer->id ?: null,
                    'images' => $producer->images(),
                    'limit' => 4,
                ])
            </div>

            <h4>{{ __('Social media') }}</h4>

            {{-- Homepage --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => __('Website'),
                    'name'  => 'link_homepage',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'https://',
                    'm_value' => $producer->link_homepage ?? ''
                ])
            </div>

            {{-- Facebook --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Facebook',
                    'name'  => 'link_facebook',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'https://',
                    'm_value' => $producer->link_facebook ?? ''
                ])
            </div>

            {{-- Twitter --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Twitter',
                    'name'  => 'link_twitter',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => __('https://'),
                    'm_value' => $producer->link_twitter ?? ''
                ])
            </div>

            {{-- Instagram --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Instagram',
                    'name'  => 'link_instagram',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => __('https://'),
                    'm_value' => $producer->link_instagram
                ])
            </div>
        </div>
        @include('new.components.forms.submit')
    </div>
</div>



