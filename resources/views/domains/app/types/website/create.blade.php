<div class="p-2">
    <label for="app-payload-url" class="form-label">{{ __('app-create.payload.url') }}</label>

    <div class="input-group">
        <input type="text" name="payload[url]" class="form-control form-control-lg" id="app-payload-url" value="{{ $REQUEST->input('payload.url') }}" />
        <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-url" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
    </div>
</div>

<div class="lg:flex">
    <div class="flex-auto p-2">
        <label for="app-payload-user" class="form-label">{{ __('app-create.payload.user') }}</label>

        <div class="input-group">
            <input type="text" name="payload[user]" class="form-control form-control-lg" id="app-payload-user" value="{{ $REQUEST->input('payload.user') }}" autocomplete="off" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-user" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
         </div>
    </div>

    <div class="flex-auto p-2">
        <label for="app-payload-password" class="form-label">{{ __('app-create.payload.password') }}</label>

        <div class="input-group">
            <input type="password" name="payload[password]" class="form-control form-control-lg" id="app-payload-password" value="{{ $REQUEST->input('payload.password') }}" autocomplete="off" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-password" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#app-payload-password" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
         </div>
    </div>
</div>

<div class="p-2">
    <button type="button" class="mr-1 tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-recovery" tabindex="-1">@icon('clipboard', 'w-4 h-4')</button>
    <button type="button" class="mr-1" title="{{ __('common.show') }}" data-password-show="#app-payload-recovery" tabindex="-1">@icon('eye', 'w-4 h-4')</button>

    <label for="app-payload-recovery" class="form-label">{{ __('app-create.payload.recovery') }}</label>

    <textarea name="payload[recovery]" class="form-control form-control-lg textarea-password" id="app-payload-recovery">{{ $REQUEST->input('payload.recovery') }}</textarea>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-create.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>
