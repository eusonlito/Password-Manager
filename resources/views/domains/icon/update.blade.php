@extends ('domains.icon.update-layout')

@section ('content')

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="icon-name" class="form-label">{{ __('icon-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="icon-name" value="{{ $row->name }}" readonly>
        </div>

        <div class="p-2">
            <label for="icon-icon" class="form-label">{{ __('icon-update.icon') }}</label>

            <div class="input-group">
                <input type="file" name="icon" class="form-control form-control-lg" id="app-icon" accept="image/png" required>
                <a href="@asset($row->public)" class="input-group-text input-group-text-lg" title="{{ __('common.view') }}" target="_blank" tabindex="-1">@icon('external-link', 'w-5 h-5')</a>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('icon-update.save') }}</button>
        </div>
    </div>
</form>

@stop
