@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('app-index.filter') }}" data-table-search="#app-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0">
            <select name="type" class="form-select form-select-lg bg-white" data-change-submit>
                <option value="">{{ __('app.type-select') }}</option>
                @foreach ($types as $key => $each)
                <option value="{{ $key }}" {{ ($filters['type'] === $key) ? 'selected' : '' }}>{{ $each }}</option>
                @endforeach
            </select>
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0">
            <select name="shared" class="form-select form-select-lg bg-white" data-change-submit>
                <option value="">{{ __('app-index.shared-select') }}</option>
                <option value="1" {{ ($filters['shared'] === '1') ? 'selected' : '' }}>{{ __('app-index.shared-yes') }}</option>
                <option value="0" {{ ($filters['shared'] === '0') ? 'selected' : '' }}>{{ __('app-index.shared-no') }}</option>
            </select>
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0">
            <select name="archived" class="form-select form-select-lg bg-white" data-change-submit>
                <option value="0" {{ ($filters['archived'] === '0') ? 'selected' : '' }}>{{ __('app-index.archived-no') }}</option>
                <option value="1" {{ ($filters['archived'] === '1') ? 'selected' : '' }}>{{ __('app-index.archived-yes') }}</option>
                <option value="all" {{ ($filters['archived'] === 'all') ? 'selected' : '' }}>{{ __('app-index.archived-all') }}</option>
            </select>
        </div>

        @if ($tags->count() > 1)
        <div class="sm:ml-4 mt-2 sm:mt-0">
            <x-select name="tag" value="code" :text="['name']" :options="$tags->toArray()" :placeholder="__('app-index.tag')" :selected="$filters['tag']" data-change-submit></x-select>
        </div>
        @endif

        @if ($teams->count() > 1)
        <div class="sm:ml-4 mt-2 sm:mt-0">
            <x-select name="team" value="code" :text="['name']" :options="$teams->toArray()" :placeholder="__('app-index.team')" :selected="$filters['team']" data-change-submit></x-select>
        </div>
        @endif

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('app.create') }}" class="btn form-control-lg">{{ __('app-index.create') }}</a>
        </div>
    </div>
</form>

@include ('domains.app.molecules.list')

<div class="box mt-2 p-2 text-right">
    <a href="{{ route('app.create') }}" class="btn form-control-lg">{{ __('app-index.create') }}</a>
</div>

@stop
