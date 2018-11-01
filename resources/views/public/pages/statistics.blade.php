@extends('public.layout-page', [
    'header' => trans('public/pages/statistics.header'),
    'subHeader' => trans('public/pages/statistics.subheader'),
    'image' => '/images/shutterstock_664170823.jpg'
])

@section('title', trans('public/pages/statistics.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        {!! trans('public/pages/statistics.info') !!}
                        <table class="table mt-5">
                            <tr>
                                <th>{{ trans('public/pages/statistics.node') }}</th>
                                <th>{{ trans('public/pages/statistics.order_count') }}</th>
                                <th>
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                                            {{ trans('public/pages/statistics.order_amount') }} {{ isset($_GET['currency']) ? $_GET['currency'] : 'EUR' }}
                                        </span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($currencies as $currency => $rate)
                                                <a class="dropdown-item" href="/statistics?currency={{ $currency }}">{{ $currency }} {{ $currencyLabels->{$currency} }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @foreach ($orders as $nodeId => $data)
                                <tr>
                                    <td>{{ $nodes->{$nodeId} }}</td>
                                    <td>{{ $data->count }}</td>
                                    <td>{{ (int) $data->amount }} {{ isset($_GET['currency']) ? $_GET['currency'] : 'EUR' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
