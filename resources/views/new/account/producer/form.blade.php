@include('new.components.progress',
[
    'active' => 1,
    'steps'  =>
        [
            trans('public/register.step_1'),
            trans('public/register.step_2'),
            trans('public/register.step_3'),
            trans('public/register.step_4')
        ]
])

<div class="container my-5">
    <h2>{{ trans('public/register.account_info') }}</h2>

    <div class="row mt-4">
        <div class="col-md-9">
            <h4>{{ trans('public/register.producer_info') }}</h4>

            {{-- Farm/Business name --}}
            <div class="form-row mt-4">
                <div class="form-group col-md-8">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.farm_business_name'),
                        'name'  => 'name',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.name')
                    ])
                </div>

                {{-- Email --}}
                <div class="form-group col-md-8">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.email'),
                        'name'  => 'email',
                        'type'  => 'email',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.email')
                    ])
                </div>

                {{-- Address --}}
                <div class="form-group col-md-8">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.address'),
                        'name'  => 'address',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.address')
                    ])
                </div>

                {{-- ZIP --}}
                <div class="form-group col-8 col-md-4">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.zip_code'),
                        'name'  => 'zip',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.zip_code')
                    ])
                </div>

                {{-- City --}}
                <div class="form-group col-8 col-md-4">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.city'),
                        'name'  => 'city',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.city')
                    ])
                </div>

                {{-- Info --}}
                <div class="form-group col-md-16">
                    @include('new.components.forms.textarea', [
                        'label' => trans('public/register.describe_farm_business'),
                        'name'  => 'info',
                        'class' => 'form-control wysiwyg',
                        'rows'  => 7,
                        'old'   => $producer->info
                    ])
                </div>

                {{-- Currency --}}
                <div class="form-group col-md-7">
                    <h4>{{ trans('public/register.payment_info') }}</h4>

                    @include('new.components.forms.dropdown', [
                        'label'       => trans('public/register.currency_products'),
                        'name'        => 'currency',
                        'class'       => 'bb-38 form-control',
                        'placeholder' => trans('public/register.choose_currency'),
                        'options'     => UnitsHelper::getCurrencies(),
                        'value'       => false
                    ])
                </div>

                {{-- Payment Info --}}
                <div class="form-group col-16">
                    @include('new.components.forms.input', [
                        'label' => trans('public/register.payment_info_with_confirm'),
                        'name'  => 'payment_info',
                        'type'  => 'text',
                        'class' => 'form-control',
                        'placeholder' => trans('public/register.write_here')
                    ])
                </div>
            </div>
        </div>

        <div class="col-md-6 offset-md-1">
            <h4>{{ trans('public/register.images') }}</h4>

            <p>{{ trans('public/register.upload_images') }}</p>
            <div class="form-row mb-5">
                @include('new.components.forms.images')
            </div>

            <h4>{{ trans('public/register.links_social_media') }}</h4>

            {{-- Homepage --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => trans('public/register.website'),
                    'name'  => 'link_homepage',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'http://'
                ])
            </div>

            {{-- Facebook --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Facebook',
                    'name'  => 'link_facebook',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'Facebook-' . trans('public/register.address_small')
                ])
            </div>

            {{-- Twitter --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Twitter',
                    'name'  => 'link_twitter',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'Twitter-' . trans('public/register.address_small')
                ])
            </div>

            {{-- Instagram --}}
            <div class="form-group">
                @include('new.components.forms.input', [
                    'label' => 'Instagram',
                    'name'  => 'link_instagram',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'Instagram-' . trans('public/register.address_small')
                ])
            </div>

            <button type="submit" class="btn btn-secondary mt-3 float-right">{{ trans('admin/producer.save_producer') }}</button>
        </div>
    </div>
</div>



