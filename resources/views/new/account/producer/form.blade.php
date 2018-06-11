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

            <div class="form-row mt-4">

                <div class="form-group col-md-8">
                    <label for="inputEmail4">{{ trans('public/register.farm_business_name') }}</label>
                    <input type="email" class="form-control-sm" id="1" placeholder="{{ trans('public/register.name') }}">
                </div>


                <div class="form-group col-md-8">
                    <label for="inputPassword4">{{ trans('public/register.email') }}</label>
                    <input type="password" class="form-control-sm" id="2" placeholder="{{ trans('public/register.email') }}">
                </div>


                <div class="form-group col-md-8">
                    <label for="inputEmail4">{{ trans('public/register.address') }}</label>
                    <input type="email" class="form-control-sm" id="3" placeholder="{{ trans('public/register.address') }}">
                </div>


                <div class="form-group col-8 col-md-4">
                    <label for="inputPassword4">{{ trans('public/register.zip_code') }}</label>
                    <input type="password" class="form-control-sm" id="4" placeholder="{{ trans('public/register.zip_code') }}">
                </div>

                <div class="form-group col-8 col-md-4">
                    <label for="inputPassword4">{{ trans('public/register.city') }}</label>
                    <input type="password" class="form-control-sm" id="5" placeholder="{{ trans('public/register.city') }}">
                </div>

                <div class="form-group col-md-16">
                    <label for="describe">{{ trans('public/register.describe_farm_business') }}</label>
                    <textarea name="info" class="form-control wysiwyg" id="describe"
                              rows="5">{{ $producer->info or '' }}</textarea>
                </div>


                <div class="form-group col-md-7">

                    <h4>{{ trans('public/register.payment_info') }}</h4>

                    <label for="inputPassword4">{{ trans('public/register.currency_products') }}</label>
                    <select class="bb-38 form-control-sm">
                        <option value="">{{ trans('public/register.choose_currency') }}</option>
                        @foreach (UnitsHelper::getCurrencies() as $currency)
                            <option value="{{ $currency }}" {{ $currency === $producer->currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-16">
                    <label for="inputPassword4">{{ trans('public/register.payment_info_with_confirm') }}</label>
                    <input type="password" class="form-control-sm" id="8" placeholder="{{ trans('public/register.write_here') }}">
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

            <div class="form-group">
                <label for="inputEmail4">{{ trans('public/register.website') }}</label>
                <input type="email" class="form-control-sm" id="9" placeholder="http://">
            </div>


            <div class="form-group">
                <label for="inputPassword4">Facebook</label>
                <input type="password" class="form-control-sm" id="10" placeholder="Facebook-{{ trans('public/register.address_small') }}">
            </div>

            <div class="form-group">
                <label for="inputEmail4">Twitter</label>
                <input type="email" class="form-control-sm" id="11" placeholder="Twitter-{{ trans('public/register.address_small') }}">
            </div>


            <div class="form-group">
                <label for="inputPassword4">Instagram</label>
                <input type="password" class="form-control-sm" id=12" placeholder="Instagram-{{ trans('public/register.address_small') }}">
            </div>

        </div>
    </div>
</div>



