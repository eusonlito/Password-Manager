@extends ('domains.team.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="team-name" class="form-label">{{ __('team-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="team-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="default" value="1" class="form-check-switch" id="team-default" {{ $REQUEST->input('default') ? 'checked' : '' }}>
                <label for="team-default" class="form-check-label">{{ __('team-update.default') }}</label>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('team-update.save') }}</button>
        </div>
    </div>
</form>

@stop
