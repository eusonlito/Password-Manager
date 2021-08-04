<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-host" class="form-label">{{ __('app-update.payload.host') }}</label>

        <div class="input-group">
            <input type="text" name="payload[host]" class="form-control form-control-lg" id="app-payload-host" value="{{ $REQUEST->input('payload.host') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-host" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-port" class="form-label">{{ __('app-update.payload.port') }}</label>

        <div class="input-group">
            <input type="password" name="payload[port]" class="form-control form-control-lg" id="app-payload-port" value="{{ $REQUEST->input('payload.port') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-port" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-port" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-user" class="form-label">{{ __('app-update.payload.user') }}</label>

        <div class="input-group">
            <input type="password" name="payload[user]" class="form-control form-control-lg" id="app-payload-user" value="{{ $REQUEST->input('payload.user') }}" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-user" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-user" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-password" class="form-label">{{ __('app-update.payload.password') }}</label>

        <div class="input-group">
            <input type="password" name="payload[password]" class="form-control form-control-lg" id="app-payload-password" value="{{ $REQUEST->input('payload.password') }}" autocomplete="off" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-password" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#app-payload-password" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
         </div>
    </div>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-update.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>