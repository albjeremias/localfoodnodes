@extends('new.public.layout',
[
    'public_nav'   => true,
    'bread_type'   => 'Index',
    'bread_result' => 'Medlemskap'
])

@section('content')

    <section id="simple-page" class="d-flex container-fluid {{ $bg  }}">
        <div class="row justify-content-center align-self-center mx-auto">
            <div class="text-uppercase">
                <h1>{{ $header }}</h1>
            </div>
        </div>
    </section>
    @yield('page-content')
@endsection
