@extends ('domains.user.profile-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="profileExport" />

    <div class="box p-5 mt-5 text-center">
        {{ __('user-profile-export.description') }}
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password" class="form-label">{{ __('user-profile-export.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="user-password">
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('user-profile-export.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('user-profile-export.save') }}</button>
        </div>
    </div>
</form>

@stop
