<?php $viewName = 'Login' ?>

@extends('new.public.layout',
[
    'no_nav' => true,
])

@section('title', trans('public/index.title'))

@section('content')

    <div class="container login">
        <div class="row">
            <div class="col-6 bg-img-party-cut login-image image p-5">
                <a href="/">
                    <img class="login-logo" src="/images/nav-logo-dark.png">
                </a>

                <div class="login-quote wc pr-5">
                    <p><a>JOHANNA ANDERSSON, DALBY</a></p>

                    <p>– “Innan du kan boka din mat behöver du bli stödmedlem, sedan kommer producenten med dina varor
                        till utlämningensplatsen...”</p>
                </div>
            </div>
            <div class="col-8 offset-1">
                <div class="row mt-5">
                    <div class="col-16 text-right mb-5">
                        <small>Har du inget konto?</small>
                        <a class="ml-3 btn btn-info bb">SKAPA KONTO</a>
                    </div>

                    <div class="col-16 mt-5">
                        <h3>Logga in på Local Food Nodes</h3>
                        <p class="black-54">Logga in med Facebook eller skriv in dina uppgifter.</p>

                        <a href="" class="btn btn-facebook w-100 mt-5">
                            <i class="fa fa-facebook-official mr-2 icon wc" aria-hidden="true"></i>
                            LOGGA IN MED FACEBOOK
                        </a>

                        <p class="text-center mt-4 black-54">Eller skriv in dina uppgifter</p>

                        <form class="">

                            <div class="form-group">
                                <label for="email-input">EMAILADRESS</label>
                                <input type="email" id="email-input" class="form-control bb-38"
                                       placeholder="johanna@email.com">
                            </div>

                            <div class="form-group pt-3">
                                <label for="pw-input">LÖSENORD</label>
                                <a class="float-right" href="#">
                                    <small>Har du glömt ditt lösenord?</small>
                                </a>
                                <input type="password" id="pw-input" class="form-control bb-38"
                                       placeholder="Skriv in ditt lösenord">
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <button type="submit" class="box-shadow btn-lg btn-primary text-uppercase">Logga in</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection