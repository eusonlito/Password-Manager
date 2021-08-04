<div class="p-2">
    <button type="button" class="tooltip mr-1" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-text" tabindex="-1">@icon('clipboard', 'w-4 h-4')</button>

    <label for="app-payload-text" class="form-label">{{ __('app-create.payload.text') }}</label>

    <textarea name="payload[text]" class="form-control form-control-lg" id="app-payload-text" rows="10">{{ $REQUEST->input('payload.text') }}</textarea>
</div>
