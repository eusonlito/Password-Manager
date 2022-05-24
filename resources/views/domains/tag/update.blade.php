@extends ('domains.tag.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="tag-name" class="form-label">{{ __('tag-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="tag-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="tag-color" class="form-label">{{ __('tag-update.color') }}</label>
            <input type="color" name="color" class="form-control form-control-lg pt-0 pb-0" id="tag-color" value="{{ $REQUEST->input('color') }}" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('tag-update.save') }}</button>
        </div>
    </div>
</form>

@stop
