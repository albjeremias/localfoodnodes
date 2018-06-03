@extends('new.account.layout',
[
    'nav_title' => 'Min Panel',
    'sub_nav' => ['dashboard', 'mina noder', 'utlämningar', 'evenemang', 'min profil'],
    'sub_nav_active' => 0
])

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')

    <div class="bg-shell">
        <div class="container nm py-5">
            <div class="row">
                <div class="col-11">
                    <div class="row">
                        <div class="col-9">
                            <div class="white-box little-min">
                                <h4>Profil-information</h4>
                                <ul class="list-unstyled list-p">
                                    <li>{{ Auth::user()->name }}</li>
                                    <li class="black-54">{{ Auth::user()->email }}</li>
                                </ul>

                                <div class="row mt-4">
                                    <div class="col-4">
                                        <h3 class="m-0">1129</h3>
                                        <small>Följda noder</small>
                                    </div>

                                    <div class="col-4">
                                        <h3 class="m-0">41</h3>
                                        <small>Producenter</small>
                                    </div>

                                    <div class="col">
                                        <h3 class="m-0">13.5 km</h3>
                                        <small>Snittavstånd till producent</small>
                                    </div>
                                </div>

                                <a class="bottom-link text-uppercase rc" href="#">redigera profil</a>
                            </div>
                        </div>

                        <div class="col-7">
                            <div class="white-box little-min">
                                <h4>Ännu inte medlem?</h4>
                                <p class="black-54">Läs mer och bli medlem</p>

                                <a class="bottom-link text-uppercase rc" href="#">blir medlem</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4 class="position-absolute">Nästa utlämning</h4>
                                <div class="row h-100">
                                    <div class="col-16 my-auto text-center">
                                        <i class="fa fa-shopping-basket icon-big" aria-hidden="true"></i>
                                        <p class="mt-4">Det finns för närvarande inga kommande utlämningar</p>
                                        <a class="btn btn-primary mt-3" href="#">Hitta nya utlämningar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4>Närliggande utlämningsplatser</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <div class="row">
                        <div class="col-16">
                            <div class="white-box big-min">
                                @include('new.components.nodes-following')
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                <h4>Evenemang</h4>

                                <ul class="list-unstyled node-list mt-4">
                                    <li>
                                        <div class="row no-gutters">
                                            <div class="col-2">
                                                <i class="fa fa-asterisk icon-green" aria-hidden="true"></i>
                                            </div>
                                            <div class="col">Grönsaksfest -
                                                <small>25 Sep</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row no-gutters">
                                            <div class="col-2">
                                            </div>
                                            <div class="col">Paprikaprovning -
                                                <small>13 Juni</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

