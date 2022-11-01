@extends ('layouts.in')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="export" />

    <div class="box p-5 text-center">
        {{ __('app-export.description') }}
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password" class="form-label">{{ __('app-export.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="user-password">
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>
    </div>

    @if ($AUTH->admin)

    <div class="box p-5 mt-5">
        <div class="p-2 form-check">
            <input type="checkbox" name="shared" value="1" class="form-check-switch" id="app-shared">
            <label for="app-shared" class="form-check-label">{{ __('app-export.shared') }}</label>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('app-export.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('app-export.save') }}</button>
        </div>
    </div>
</form>

@stop
