@extends('new.public.layout',
[
    'public_nav'   => true,
    'bread_type'   => 'Index',
    'bread_result' => $title
])

@section('content')

    <section id="simple-page_a" class="container nms pt-5 pb-4">
        <h2>{{ $header }}</h2>
        <p class="mt-3 black-54">{{ $sub_header }}</p>
    </section>
    @yield('page-content')
@endsection
