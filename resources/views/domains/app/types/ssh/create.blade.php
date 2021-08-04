<div class="lg:flex">
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
    <button type="button" class="mr-1 tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-public" tabindex="-1">@icon('clipboard', 'w-4 h-4')</button>
    <button type="button" class="mr-1" title="{{ __('common.show') }}" data-password-show="#app-payload-public" tabindex="-1">@icon('eye', 'w-4 h-4')</button>

    <label for="app-payload-public" class="form-label">{{ __('app-create.payload.public') }}</label>

    <textarea name="payload[public]" class="form-control form-control-lg textarea-password" id="app-payload-public">{{ $REQUEST->input('payload.public') }}</textarea>
</div>

<div class="p-2">
    <button type="button" class="mr-1 tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-private" tabindex="-1">@icon('clipboard', 'w-4 h-4')</button>
    <button type="button" class="mr-1" title="{{ __('common.show') }}" data-password-show="#app-payload-private" tabindex="-1">@icon('eye', 'w-4 h-4')</button>

    <label for="app-payload-private" class="form-label">{{ __('app-create.payload.private') }}</label>

    <textarea name="payload[private]" class="form-control form-control-lg textarea-password" id="app-payload-private">{{ $REQUEST->input('payload.private') }}</textarea>
</div>

<div class="p-2">
    <label for="app-payload-notes" class="form-label">{{ __('app-create.payload.notes') }}</label>
    <textarea name="payload[notes]" class="form-control form-control-lg" id="app-payload-notes">{{ $REQUEST->input('payload.notes') }}</textarea>
</div>
