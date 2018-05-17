<form action="/account/user/insert" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">
            {{ trans('admin/user.name') }}
            @include('account.field-error', ['field' => 'name'])
        </label>
        <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('admin/user.name_placeholder') }}" value="{{ Request::old('name') }}">
    </div>
    <div class="form-group">
        <label for="email">
            {{ trans('admin/user.email') }}
            @include('account.field-error', ['field' => 'email'])
        </label>
        <input type="email" name="email" class="form-control" id="email" placeholder="{{ trans('admin/user.email_placeholder') }}" value="{{ Request::old('email')}}">
    </div>
    <div class="form-group">
        <label for="phone">
            {{ trans('admin/user.phone') }}
            @include('account.field-error', ['field' => 'phone'])
        </label>
        <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ trans('admin/user.phone_placeholder') }}" value="{{ Request::old('phone')}}">
        <small class="form-text text-muted">{{ trans('admin/user.phone_info') }}</small>
    </div>
    <div class="form-group">
        <label for="password">
            {{ trans('admin/user.password') }}
            @include('account.field-error', ['field' => 'password'])
        </label>
        <input type="password" name="password" class="form-control" id="password" placeholder="{{ trans('admin/user.password_placeholder') }}">
    </div>

    <div class="form-group">
        <label>
            {{ trans('admin/user.gdpr') }}
            @include('account.field-error', ['field' => 'gdpr'])
        </label>
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="gdpr">
                {{ trans('admin/user.gdpr_checkbox') }}
            </label>
            <small class="form-text text-muted"><a href="#" data-toggle="modal" data-target="#terms-modal">{{ trans('admin/user.term_link') }}</a></small>
        </div>
    </div>

    <div class="text-center mt-5">
        <button type="submit" class="btn btn-success">{{ trans('admin/user.create_account') }}</button>
        <a class="d-block mt-2" href="/login">{{ trans('public/login.or_login') }}</a>
    </div>
</form>
