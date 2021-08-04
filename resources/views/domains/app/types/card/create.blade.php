<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-holder" class="form-label">{{ __('app-create.payload.holder') }}</label>

        <div class="input-group">
            <input type="text" name="payload[holder]" class="form-control form-control-lg" id="app-payload-holder" value="{{ $REQUEST->input('payload.holder') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-holder" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-number" class="form-label">{{ __('app-create.payload.number') }}</label>

        <div class="input-group">
            <input type="text" name="payload[number]" class="form-control form-control-lg" id="app-payload-number" value="{{ $REQUEST->input('payload.number') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-number" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-pin" class="form-label">{{ __('app-create.payload.pin') }}</label>

        <div class="input-group">
            <input type="text" name="payload[pin]" class="form-control form-control-lg" id="app-payload-pin" value="{{ $REQUEST->input('payload.pin') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-pin" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-pin" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-cvc" class="form-label">{{ __('app-create.payload.cvc') }}</label>

        <div class="input-group">
            <input type="text" name="payload[cvc]" class="form-control form-control-lg" id="app-payload-cvc" value="{{ $REQUEST->input('payload.cvc') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-cvc" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-cvc" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-expires" class="form-label">{{ __('app-create.payload.expires') }}</label>

        <div class="input-group">
            <input type="text" name="payload[expires]" class="form-control form-control-lg" id="app-payload-expires" value="{{ $REQUEST->input('payload.expires') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-expires" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-expires" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-create.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>
