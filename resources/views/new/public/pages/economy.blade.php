@extends('new.layouts.simple-page', [
    'header'     => 'Total transparens',
    'sub_header' => 'Underrubrik underrubrik',
    'title'      => 'Ekonomi',
    'bg'         => 'bg-accent-light-24'
])

@section('title', 'Ekonomi')

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                <p>
                    Local Food Nodes har 100% financiell transparens. Här under ser ni alla årets inkomster och
                    kostnader summerade. Gå till vår finanssida för mer detaljerade finanser och förklaring kring varför
                    vi tror på transparens.
                </p>
                <p>
                    Local Food Nodes har 100% financiell transparens. Här under ser ni alla årets inkomster och
                    kostnader summerade. Gå till vår finanssida för mer detaljerade finanser och förklaring kring varför
                    vi tror på transparens.
                </p>

                <p>
                    Local Food Nodes har 100% financiell transparens. Här under ser ni alla årets inkomster och
                    kostnader summerade. Gå till vår finanssida för mer detaljerade finanser och förklaring kring varför
                    vi tror på transparens.
                </p>
            </div>

            <div class="col-16 col-md-6 offset-md-2">
                <div class="my-5 mt-md-0">
                    <h3>INTÄKTER 2017</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection