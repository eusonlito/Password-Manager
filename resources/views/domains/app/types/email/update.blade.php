<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-username" class="form-label">{{ __('app-update.payload.username') }}</label>

        <div class="input-group">
            <input type="text" name="payload[username]" class="form-control form-control-lg" id="app-payload-username" value="{{ $REQUEST->input('payload.username') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-username" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-password" class="form-label">{{ __('app-update.payload.password') }}</label>

        <div class="input-group">
            <input type="password" name="payload[password]" class="form-control form-control-lg" id="app-payload-password" value="{{ $REQUEST->input('payload.password') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-password" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-update.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>
