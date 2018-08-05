<?php $viewName = 'Register' ?>

@extends('new.public.layout',
[
    'no_nav' => true,
])

@section('title', trans('public/register.title_register'))

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
                        <small>{{ trans('public/register.have_account') }}</small>
                        <a href="/login" class="ml-3 btn btn-info bb">{{ trans('public/register.login') }}</a>
                    </div>

                    <div class="col-16 mt-5">
                        <h3>{{ trans('public/register.start_free') }}</h3>
                        <p class="black-54">{{ trans('public/register.login_fb_or_create') }}</p>

                        <a href="" class="btn btn-facebook w-100 mt-5">
                            <i class="fa fa-facebook-official mr-2 icon wc" aria-hidden="true"></i>
                            {{ trans('public/register.login_fb') }}
                        </a>

                        <p class="text-center mt-4 black-54">{{ trans('public/register.or_create_account') }}</p>

                        <form action="/account/user/insert" method="post">
                            {{ csrf_field() }}

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => trans('public/register.email'),
                                    'label_cap'   => true,
                                    'name'        => 'email',
                                    'type'        => 'email',
                                    'class'       => 'form-control bb-38',
                                    'placeholder' => 'johanna@email.com'
                                ])
                            </div>

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => trans('public/register.name'),
                                    'label_cap'   => true,
                                    'name'        => 'name',
                                    'type'        => 'text',
                                    'class'       => 'form-control bb-38',
                                    'placeholder' => 'Johanna Andersson'
                                ])
                            </div>

                            <div class="form-group pt-3">
                                @include('new.components.forms.input', [
                                    'label'       => trans('public/register.pw'),
                                    'label_cap'   => true,
                                    'name'        => 'password',
                                    'type'        => 'password',
                                    'class'       => 'form-control bb-38',
                                    'placeholder' => '5+ ' . trans('public/register.characters')
                                ])
                            </div>

                            <div class="form-group">
                                <label>
                                    @include('account.field-error', ['field' => 'gdpr'])
                                </label>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="gdpr">
                                        <small>{{ trans('admin/user.gdpr_checkbox') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <button type="submit" class="box-shadow btn-lg btn-primary text-uppercase">
                                    {{ trans('public/register.create_account') }}
                                </button>
                            </div>

                            <div class="w-100 text-center mt-4">
                                <small class="text-center">{{ trans('public/register.accept_terms') }}
                                </small>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection