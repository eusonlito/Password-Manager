<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="user-name" class="form-label">{{ __('user-profile.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="user-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <label for="user-email" class="form-label">{{ __('user-profile.email') }}</label>
        <input type="email" name="email" class="form-control form-control-lg" id="user-email" value="{{ $REQUEST->input('email') }}" required>
    </div>

    @if ($certificate_enabled)

    <div class="p-2">
        <label for="user-certificate" class="form-label">{{ __('user-profile.certificate') }}</label>

        <div class="input-group">
            <input type="text" name="certificate" class="form-control form-control-lg" id="user-certificate" value="{{ $REQUEST->input('certificate') }}">

            <a href="{{ route('user.profile.certificate') }}" class="input-group-text input-group-text-lg" title="{{ __('user-profile.certificate-load') }}" tabindex="-1">
                @icon('download', 'w-5 h-5')
            </a>
        </div>
    </div>

    @endif

    <div class="p-2">
        <label for="user-password" class="form-label">{{ __('user-profile.password') }}</label>

        <div class="input-group">
            <input type="password" name="password" class="form-control form-control-lg" id="user-password">

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#user-password" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    @if ($certificate_enabled)

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="password_enabled" value="1" class="form-check-switch" id="user-password_enabled" {{ $row->password_enabled ? 'checked' : '' }}>
            <label for="user-password_enabled" class="form-check-label">{{ __('user-profile.password_enabled') }}</label>
        </div>
    </div>

    @endif

    <div class="flex">
        <div class="flex-1 p-2">
            <label for="user-api_key" class="form-label">{{ __('user-profile.api_key') }}</label>

            <div class="input-group">
                <input type="password" name="api_key" class="form-control form-control-lg" id="user-api_key" value="{{ $row->api_key }}">

                <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#user-api_key" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-api_key" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#user-api_key" data-password-generate-format="uuid" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
            </div>
        </div>

        <div class="flex-1 p-2">
            <label for="user-api_secret" class="form-label">{{ __('user-profile.api_secret') }}</label>

            <div class="input-group">
                <input type="password" name="api_secret" class="form-control form-control-lg" id="user-api_secret">

                <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#user-api_secret" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-api_secret" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#user-api_secret" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
            </div>
        </div>
    </div>
</div>
