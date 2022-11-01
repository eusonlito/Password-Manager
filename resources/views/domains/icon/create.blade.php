@extends ('layouts.in')

@section ('body')

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="create" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="icon-name" class="form-label">{{ __('icon-create.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="icon-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="icon-icon" class="form-label">{{ __('icon-create.icon') }}</label>
            <input type="file" name="icon" class="form-control form-control-lg" id="app-icon" accept="image/png" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('icon-create.save') }}</button>
        </div>
    </div>
</form>

@stop
