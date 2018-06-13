<?php $viewName = 'Login' ?>

@extends('new.public.layout',
[
    'no_nav' => true,
])

@section('title', trans('public/login.title'))

@section('content')

    <div class="container login">
        <div class="row">
            <div class="d-none d-md-block col-md-6 bg-img-party-cut login-image image p-5">
                <a href="/">
                    <img class="login-logo" src="/images/nav-logo-dark.png">
                </a>

                <div class="login-quote wc pr-5">
                    <p><a class="text-uppercase">{{ trans('public/login.quote_name') }}</a></p>

                    <p>– “{{ trans('public/login.quote') }}”</p>
                </div>
            </div>
            <div class="col-md-8 offset-md-1">
                <div class="row mt-5">
                    <div class="col-16 text-right mb-5">
                        <small>{{ trans('public/login.no_account') }}</small>
                        <a class="ml-3 btn btn-info bb">{{ trans('public/login.create') }}</a>
                    </div>

                    <div class="col-16 mt-5">
                        <h3>{{ trans('public/login.login_lfn') }}</h3>
                        <p class="black-54">{{ trans('public/login.login_fb_or_input') }}</p>

                        <a href="" class="btn btn-facebook w-100 mt-5">
                            <i class="fa fa-facebook-official mr-2 icon wc text-uppercasex" aria-hidden="true"></i>
                            {{ trans('public/login.login_fb') }}
                        </a>

                        <p class="text-center mt-4 black-54">{{ trans('public/login.or_input') }}</p>

                        <form action="/authenticate" method="post">

                            <div class="form-group">
                                <label class="text-uppercase" for="email-input">{{ trans('public/login.email') }}</label>
                                <input type="email" id="email-input" class="form-control bb-38"
                                       placeholder="johanna@email.com">
                            </div>

                            <div class="form-group pt-3">
                                <label class="text-uppercase" for="pw-input">{{ trans('public/login.password') }}</label>
                                <a class="float-right" href="#">
                                    <small>{{ trans('public/login.forgot') }}</small>
                                </a>
                                <input type="password" id="pw-input" class="form-control bb-38"
                                       placeholder="{{ trans('public/login.write_pw') }}">
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <button type="submit" class="box-shadow btn-lg btn-primary text-uppercase">{{ trans('public/login.login') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection