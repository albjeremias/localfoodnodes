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

                        <h3>{!! trans('public/pages/membership.block_2_header') !!}</h3>
                        {!! trans('public/pages/membership.block_2_content') !!}

                        <h3>{!! trans('public/pages/membership.block_3_header') !!}</h3>
                        {!! trans('public/pages/membership.block_3_content') !!}
                    </div>
                </div>

                <div class="row mt-5 mb-5 justify-content-center">
                    <div class="col-12">
                        @if (Auth::check())
                            <div class="card">
                                <div class="card-body body-text">
                                    <h3>{!! trans('admin/user.membership') !!}</h3>
                                    @include('account.user.membership-form')
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body body-text">
                                    <h3>{!! trans('admin/user.create_account') !!}</h3>
                                    @include('public.user.create-user-form')
                                </div>
                            </div>
                        @endif
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