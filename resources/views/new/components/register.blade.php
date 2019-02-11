<div class="container py-5">
    <div class="row my-5">
        <div class="col-14 text-center m-auto">
            <h2>{{ __('Be a part of Local Food Nodes') }}</h2>

            <form class="row py-3">
                <div class="col-lg col-sm-8">
                    @include('new.components.forms.input', [
                        'name'  => 'name',
                        'type'  => 'text',
                        'class' => 'form-control-lg input-group',
                        'placeholder' => __('Your name')
                    ])
                </div>

                <div class="col-lg col-sm-8  mt-3 mt-sm-0">
                    @include('new.components.forms.input', [
                        'name'  => 'email',
                        'type'  => 'email',
                        'class' => 'form-control-lg input-group',
                        'placeholder' => __('Your email')
                    ])
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    @include('new.components.forms.input', [
                        'name'  => 'password',
                        'type'  => 'password',
                        'class' => 'form-control-lg input-group',
                        'placeholder' => __('Create password')
                    ])
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    @include('new.components.forms.dropdown', [
                        'name'        => 'language',
                        'class'       => 'custom-select text-uppercase',
                        'placeholder' => __('Language'),
                        'options'     => config('app.locales'),
                        'value'       => true,
                        'val_key'     => false,
                    ])
                </div>

                <div class="col-lg-4 col-xl mt-4 mt-lg-0">
                    <button type="submit" class="btn-lg btn-secondary text-uppercase">{{ __('Create account') }}</button>
                </div>
            </form>

            <small>
                {{ __('Accept terms') }} <a class="rc" href="#">{{ __('terms') }}</a>
            </small>
        </div>
    </div>
</div>