@extends('new.layouts.simple-page', [
    'header' => 'Framtidens matförsörjning',
    'sub_header' => 'Välj själv hur mycket du vill vara med och betala',
    'title'      => 'Medlemskap',
    'bg' => 'bg-accent-light-24'
])

@section('title', trans('public/pages/membership.title'))

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                <p class="">
                    Genom att bli medlem medfinansierar du satsningar på att göra maten mer lokal igen. Tillsammans
                    skapar
                    vi ekonomiska förutsättningar för att stötta nya former av lokal organisering och en mer lokal
                    matmarknad.
                    Med våra gemensamma insatser kan vi tillsammans staka ut riktingen för framtidens matförsörjning och
                    skapa
                    oss gemensamma resurser för bättre möjlighet till påverkan.
                </p>
            </div>

            <div class="col-16 offset-0 col-md-6 offset-md-2 offset-lg-1 offset-xl-0">
                <div class="text-center">
                    <div class="my-5 mt-lg-0">
                        @include('new.components.statistics.supporting-members')
                    </div>
                    @include('new.components.statistics.average-fee')
                </div>
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection