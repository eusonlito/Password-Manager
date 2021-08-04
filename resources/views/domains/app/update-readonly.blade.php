@extends ('layouts.in')

@section ('body')

<div data-disabled>
    <div class="box p-5">
        <label for="app-type" class="form-label">{{ __('app-update.type') }}</label>

        <select class="form-select form-select-lg bg-white" readonly disabled>
            <option>{{ $row->typeTitle() }}</option>
        </select>
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="app-name" class="form-label">{{ __('app-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="app-name" value="{{ $row->name }}">
        </div>

        <div class="p-2">
            <label for="app-tags" class="form-label">{{ __('app-update.tags') }}</label>
            <input type="text" name="tags[]" class="form-control form-control-lg" id="app-tags" value="{{ $row->tags->pluck('name')->implode(', ') }}">
        </div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        @include ('domains.app.types.'.$row->type.'.update')
    </div>
</div>

@stop
