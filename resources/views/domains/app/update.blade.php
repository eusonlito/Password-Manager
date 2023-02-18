@extends ('layouts.in')

@section ('body')

<div class="box p-5">
    <div class="p-2">
        <form method="get">
            <x-select name="type" id="app-type" :options="$types" :label="__('app-create.type')" :selected="$REQUEST->input('type')" :placeholder="__('app-create.type-select')" data-change-submit></x-select>
        </form>
    </div>
</div>

@if ($type)

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="update" />
    <input type="hidden" name="type" value="{{ $type }}" />

    <div class="box p-5 mt-5">
        <div class="lg:flex">
            <div class="flex-1 p-2">
                <label for="app-name" class="form-label">{{ __('app-update.name') }}</label>
                <input type="text" name="name" class="form-control form-control-lg" id="app-name" value="{{ $REQUEST->input('name') }}" required>
            </div>

            <div class="flex-1 p-2">
                <label for="app-icon" class="form-label">{{ __('app-update.icon') }}</label>

                <div class="input-group">
                    <input type="file" name="icon" class="form-control form-control-lg" id="app-icon" accept="image/png">
                    <label class="input-group-text input-group-text-lg" title="{{ __('app-update.icon_reset') }}">
                        <input type="checkbox" name="icon_reset" value="1" id="app-icon_reset">
                        @icon('refresh-cw', 'ml-1 w-5 h-5')
                    </label>
                    <a href="@asset($row->icon)" class="input-group-text input-group-text-lg" title="{{ __('common.view') }}" target="_blank" tabindex="-1">@icon('external-link', 'w-5 h-5')</a>
                    <a href="https://www.google.es/search?as_st=y&tbm=isch&as_q={{ $image_search }}+logo&as_epq=&as_oq=&as_eq=&cr=&as_sitesearch=&safe=images&tbs=isz:l,iar:s,ift:png" class="input-group-text input-group-text-lg" title="{{ __('app-update.icon-search') }}" rel="nofollow noopener noreferrer" target="_blank" tabindex="-1">@icon('search', 'w-5 h-5')</a>
                </div>
            </div>
        </div>

        @if ($teams->count() > 1)

        <div class="p-2">
            <x-select name="teams[]" value="id" :text="['name']" :options="$teams->toArray()" :label="__('app-update.teams')" :selected="$row->teams->pluck('id')->toArray()" class="tom-select w-full" id="app-teams" multiple required></x-select>
        </div>

        @else

        <input type="hidden" name="teams[]" value="{{ $teams->first()->id ?? '' }}" />

        @endif

        <div class="p-2">
            <x-select name="tags[]" value="id" :text="['name']" :options="$tags->toArray()" :label="__('app-update.tags')" :selected="$row->tags->pluck('id')->toArray()" class="tom-select w-full" id="app-tags" data-create multiple></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        @include ('domains.app.types.'.$type.'.update')

        <div class="pr-2 text-right text-gray-600 text-xs mt-0.5">{{ __('app-update.fields-encrypted') }}</div>
    </div>

    @include ('domains.app.molecules.create-update-files', ['row' => $row, 'files' => $files])

    @if ($row->canEdit($AUTH))

    <div class="box p-5 mt-5">
        <div class="p-2 form-check">
            <input type="checkbox" name="shared" value="1" class="form-check-switch" id="app-shared" {{ $REQUEST->input('shared') ? 'checked' : '' }}>
            <label for="app-shared" class="form-check-label">{{ __('app-update.shared') }}</label>
        </div>

        <div class="p-2 form-check">
            <input type="checkbox" name="editable" value="1" class="form-check-switch" id="app-editable" {{ $REQUEST->input('editable') ? 'checked' : '' }}>
            <label for="app-editable" class="form-check-label">{{ __('app-update.editable') }}</label>
        </div>

        <div class="p-2 form-check">
            <input type="checkbox" name="archived" value="1" class="form-check-switch" id="app-archived" {{ $REQUEST->input('archived') ? 'checked' : '' }}>
            <label for="app-archived" class="form-check-label">{{ __('app-update.archived') }}</label>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('app-update.delete.button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('app-update.save') }}</button>
        </div>
    </div>
</form>

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('app.delete', $row->id) }}" method="post">
                    <input type="hidden" name="_action" value="delete" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                        <div class="text-3xl mt-5">{{ __('app-update.delete.title') }}</div>
                        <div class="text-gray-600 mt-2">{{ __('app-update.delete.message') }}</div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('app-update.delete.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('app-update.delete.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

@stop
