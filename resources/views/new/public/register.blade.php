<?php $viewName = 'Register' ?>

@extends('new.public.layout',
[
    'no_nav' => true,
])

@section('title', trans('public/index.title'))

@section('content')

    <div class="container login">
        <div class="row">
            <div class="d-none d-md-block col-md-6 bg-img-party-cut login-image image p-5">
                <a href="/">
                    <img class="login-logo" src="/images/nav-logo-dark.png">
                </a>

                <div class="login-quote wc pr-5">
                    <p><a>JOHANNA ANDERSSON, DALBY</a></p>

                    <p>– “Innan du kan boka din mat behöver du bli stödmedlem, sedan kommer producenten med dina varor
                        till utlämningensplatsen...”</p>
                </div>
            </div>
            <div class="col-md-8 offset-md-1">
                <div class="row mt-5">
                    <div class="col-16 text-right mb-5">
                        <small>Har du redan ett konto?</small>
                        <a class="ml-3 btn btn-info bb">LOGGA IN</a>
                    </div>

                    <div class="col-16 mt-5">
                        <h3>Kom igång helt gratis</h3>
                        <p class="black-54">Logga in med Facebook eller skapa ett konto hos oss.</p>

                        <a href="" class="btn btn-facebook w-100 mt-5">
                            <i class="fa fa-facebook-official mr-2 icon wc" aria-hidden="true"></i>
                            LOGGA IN MED FACEBOOK
                        </a>

                        <p class="text-center mt-4 black-54">Eller skapa ett konto</p>

                        <form action="/account/user/insert" method="post">

                            <div class="form-group pt-3">
                                <label for="email-input">EMAILADRESS</label>
                                <input type="email" id="email-input" class="form-control bb-38"
                                       placeholder="johanna@email.com">
                            </div>

                            <div class="form-group pt-3">
                                <label for="name-input">NAMN</label>
                                <input type="text" id="name-input" class="form-control bb-38"
                                       placeholder="Johanna Andersson">
                            </div>

                            <div class="form-group pt-3">
                                <label for="pw-input">LÖSENORD</label>
                                <input type="password" id="pw-input" class="form-control bb-38"
                                       placeholder="5+ tecken">
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <button type="submit" class="box-shadow btn-lg btn-primary text-uppercase">Skapa konto
                                </button>
                            </div>

                            <div class="w-100 text-center mt-4">
                                <small class="text-center">Genom att klicka på "Skapa konto" godkänner jag Local Food
                                    Nodes Terms of Service och Privacy Policy.
                                </small>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection