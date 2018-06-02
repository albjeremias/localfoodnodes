@extends('new.layouts.simple-page', [
    'header' => 'Längtan att göra maten lokal igen',
    'sub_header' => '#LETSGETSOCIAL',
    'title'      => 'Om oss',
    'bg' => 'bg-accent-light-24'
])

@section('title', 'Om oss')

@section('page-content')

    <div class="container pb-5">
        <div class="row">
            <div class="col-16 col-md-8">
                <p>
                    Anledningen till att vi skapar Local Food Nodes är att vi vill skapa nya kopplingar direkt mellan matproducenter och matkonsumenter samtidigt som vi vill stärka de lokala kopplingar som redan finns. Vi vill möjliggöra direkta transaktioner, resilienta samhällen och återfå närheten till maten vi äter och hur den är producerad. En vilja att göra maten lokal igen.
                </p>
                <p>
                    Resultatet är ett öppet digitalt verktyg där producenten presenterar sina varor, konsumenten bokar det man vill ha och betalar direkt till producenten. Utlämning och upphämtning av varorna sker sedan på en förutbestämd tid och plats, en nod (namnet kommer från konceptet “noder i ett nätverk”), där alla konsumenter och producenter samlas. På det viset kan du som konsument hämta upp varor från flera producenter på samma gång och som producent kan du lämna ut till flera kunder samtidigt
                </p>
                <p>
                    Med Local food nodes vill vi också skapa ett öppet och kollaborativt crowdfunding-verktyg för att främja utvecklingen av framtida matsystem, friskare jordbruk och mer lokalekonomisk aktivitet.
                </p>
                <p>
                    Genom att använda plattformen och stötta projektet blir du medskapare och medfinansiär till en ny modell för produktion och distribution av lokal mat. Årliga medlemsavgifter, som du som användare själv sätter storleken på, kommer att hjälpa till att göra denna modell precis så användbar som vi, tillsammans, bestämmer oss för att göra den.
                </p>
                <p>
                    Välkommen till Local Food Nodes, en plattform där vi skapar lokala matsystem, tillsammans.
                </p>
            </div>

            <div class="col-16 col-md-6 offset-md-2">
            </div>
        </div>
    </div>

    <div class="bg-accent-light-12">
        @include('new.components.register')
    </div>
@endsection