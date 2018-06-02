<div class="container py-5">
    <div class="row my-5">
        <div class="col-14 text-center m-auto">
            <h2>{{ trans('public/index.be_part_of') }}</h2>

            <form class="row py-3">

                <div class="col-lg col-sm-8">
                    <input type="text" class="form-control input-group"
                           placeholder="{{ trans('public/index.your_name') }}">
                </div>

                <div class="col-lg col-sm-8  mt-3 mt-sm-0">
                    <input type="text" class="form-control input-group"
                           placeholder="{{ trans('public/index.your_email') }}">
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    <input type="text" class="form-control input-group" placeholder="{{ trans('public/index.create_pw') }}">
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    <select class="custom-select text-uppercase">
                        <option selected>{{ trans('public/nav.lang_swe') }}</option>
                        @foreach (config('app.locales') as $key => $value)
                            <option>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col mt-4 mt-lg-0">
                    <button type="submit" class="btn-lg btn-secondary text-uppercase">{{ trans('public/index.create_user') }}</button>
                </div>
            </form>

            <small>
                {{ trans('public/index.accept_terms') }} <a class="rc" href="#">{{ trans('public/index.terms') }}</a>
            </small>

        </div>
    </div>
</div>