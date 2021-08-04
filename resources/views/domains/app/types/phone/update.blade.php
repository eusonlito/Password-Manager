<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-number" class="form-label">{{ __('app-update.payload.number') }}</label>

        <div class="input-group">
            <input type="text" name="payload[number]" class="form-control form-control-lg" id="app-payload-number" value="{{ $REQUEST->input('payload.number') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-number" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-sim" class="form-label">{{ __('app-update.payload.sim') }}</label>

        <div class="input-group">
            <input type="text" name="payload[sim]" class="form-control form-control-lg" id="app-payload-sim" value="{{ $REQUEST->input('payload.sim') }}" />
            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-sim" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="lg:flex">
    <div class="flex-1 p-2">
        <label for="app-payload-pin" class="form-label">{{ __('app-update.payload.pin') }}</label>

        <div class="input-group">
            <input type="password" name="payload[pin]" class="form-control form-control-lg" id="app-payload-pin" value="{{ $REQUEST->input('payload.pin') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-pin" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-pin" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-puk" class="form-label">{{ __('app-update.payload.puk') }}</label>

        <div class="input-group">
            <input type="password" name="payload[puk]" class="form-control form-control-lg" id="app-payload-puk" value="{{ $REQUEST->input('payload.puk') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-puk" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-puk" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="flex-1 p-2">
        <label for="app-payload-unlock" class="form-label">{{ __('app-update.payload.unlock') }}</label>

        <div class="input-group">
            <input type="password" name="payload[unlock]" class="form-control form-control-lg" id="app-payload-unlock" value="{{ $REQUEST->input('payload.unlock') }}" step="1" />

            <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-unlock" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#app-payload-unlock" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-update.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>