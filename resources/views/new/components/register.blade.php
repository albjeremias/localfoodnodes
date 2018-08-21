<div class="container py-5">
    <div class="row my-5">
        <div class="col-14 text-center m-auto">
            <h2>@lang('Become a part of Local Food Nodes!')</h2>

            <form class="row py-3">

                <div class="col-lg col-sm-8">
                    <input type="text" class="form-control input-group"
                           placeholder="@lang('Your name')">
                </div>

                <div class="col-lg col-sm-8  mt-3 mt-sm-0">
                    <input type="text" class="form-control input-group"
                           placeholder="@lang('Your email')">
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    <input type="text" class="form-control input-group" placeholder="@lang('Password')">
                </div>

                <div class="col-lg col-sm-8 mt-3 mt-lg-0">
                    <select class="custom-select text-uppercase">
                        <option selected>{{ trans('public/nav.lang_swe') }}</option>
                        @foreach (config('app.locales') as $key => $value)
                            <option>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-xl mt-4 mt-lg-0">
                    <button type="submit" class="btn-lg btn-secondary text-uppercase">@lang('Create account')</button>
                </div>
            </form>

            <small>
                @lang('By creating an account you accept our') <a class="rc" href="#">@lang('terms of condition')</a>
            </small>

        </div>
    </div>
</div>