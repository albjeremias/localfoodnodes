@extends('new.public.layout',
[
    'no_nav' => true,
])

@section('title', __('Register'))

@section('content')

    <div class="container login">
        <div class="row">
            <div class="d-none d-md-block col-md-6 bg-img-party-cut login-image image p-5">
                <a href="/">
                    <img class="login-logo" src="/images/nav-logo-dark.png">
                </a>

                <div class="login-quote wc pr-5">
                    <p><a class="text-uppercase">{{ __('Johanna Andersson, Dalby') }}</a></p>
                    <p>– “{{ __('Innan du kan boka din mat behöver du bli stödmedlem, sedan kommer producenten med dina varor till utlämningensplatsen...') }}”</p>
                </div>
            </div>
            <div class="col-md-8 offset-md-1">
                <div class="row mt-5">
                    <div class="col-16 text-right mb-5">
                        <small>{{ __('Have an account?') }}</small>
                        <a href="/login" class="ml-3 btn btn-info bb">{{ __('Login') }}</a>
                    </div>

                    <div class="col-16 mt-5">
                        <h3>{{ __('Create your account for free') }}</h3>
                        <p class="black-54">{{ __('Create your account with Facebook or account credentials') }}</p>

                        <a href="" class="btn btn-facebook w-100 mt-5">
                            <i class="fa fa-facebook-official mr-2 icon wc" aria-hidden="true"></i>
                            {{ __('Register with Facebook') }}
                        </a>

                        <p class="text-center mt-4 black-54">{{ __('Create account') }}</p>

                        <form action="/account/user/insert" method="post">
                            {{ csrf_field() }}

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => __('Email'),
                                    'label_cap'   => true,
                                    'name'        => 'email',
                                    'type'        => 'email',
                                    'class'       => 'form-control-lg w-100 bb-38',
                                    'placeholder' => 'johanna@email.com'
                                ])
                            </div>

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => __('Name'),
                                    'label_cap'   => true,
                                    'name'        => 'name',
                                    'type'        => 'text',
                                    'class'       => 'form-control-lg w-100 bb-38',
                                    'placeholder' => 'Johanna Andersson'
                                ])
                            </div>

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => __('Password'),
                                    'label_cap'   => true,
                                    'name'        => 'password',
                                    'type'        => 'password',
                                    'class'       => 'form-control-lg w-100 bb-38',
                                    'placeholder' => '8+ ' . __('characters')
                                ])
                            </div>

                            <div class="form-group">

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="gdpr">
                                        <small>{{ __('Approve our privacy policy and terms') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <button type="submit" class="box-shadow btn-lg btn-primary text-uppercase">
                                    {{ __('Create account') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection