@extends('public.layout-page', [
    'header' => trans('public/pages/membership.header'),
    'subHeader' => trans('public/pages/membership.sub_header'),
    'image' => '/images/cows-bw.jpg'
])

@section('title', trans('public/pages/membership.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        {!! trans('public/pages/membership.body') !!}

                        <div class="metrics row">
                            <div class="metric col">
                                <i class="fa fa-user"></i>
                                <div class="metric-inner">
                                    <div class="value">{{ $members }}</div>
                                    <div class="label">{{ trans('public/pages/membership.supporting') }}</div>
                                </div>
                            </div>
                            <div class="metric col">
                                <i class="fa fa-money"></i>
                                <div class="metric-inner">
                                    <div class="value">{{ $averageMembership }} SEK</div>
                                    <div class="label">{{ trans('public/pages/membership.avg_fee') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-5 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body body-text">
                        @if (Auth::check())
                            @include('account.user.membership-form')
                        @else
                            @include('public.user.create-user-form')
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        <h2>{!! trans('public/pages/membership.block_2_header') !!}</h2>
                        {!! trans('public/pages/membership.block_2_content') !!}

                        <h2>{!! trans('public/pages/membership.block_3_header') !!}</h2>
                        {!! trans('public/pages/membership.block_3_content') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modal')
    <div class="modal fade" id="terms-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('admin/user.terms_of_use') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body body-text">
                    <p>{!! trans('admin/terms.user') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection