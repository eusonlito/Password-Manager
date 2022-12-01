@extends ('layouts.in')

@section ('body')

<div class="box p-5">
    <div class="p-2">
        <form method="get">
            <x-select name="type" id="app-type" :options="$types" :label="__('app-create.type')" :selected="$REQUEST->input('type')" :placeholder="__('app-create.type-select')" data-change-submit required></x-select>
        </form>
    </div>
</div>

@if ($type)

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="type" value="{{ $type }}" />

    <div class="box p-5 mt-5">
        <div class="lg:flex">
            <div class="flex-1 p-2">
                <label for="app-name" class="form-label">{{ __('app-create.name') }}</label>
                <input type="text" name="name" class="form-control form-control-lg" id="app-name" value="{{ $REQUEST->input('name') }}" autofocus required>
            </div>

            <div class="flex-1 p-2">
                <label for="app-icon" class="form-label">{{ __('app-create.icon') }}</label>

                <div class="input-group">
                    <input type="file" name="icon" class="form-control form-control-lg" id="app-icon" accept="image/png">
                    <a href="https://www.google.es/search?as_st=y&tbm=isch&as_q=logo&as_epq=&as_oq=&as_eq=&cr=&as_sitesearch=&safe=images&tbs=isz:l,iar:s,ift:png" class="input-group-text input-group-text-lg" title="{{ __('app-create.icon-search') }}" rel="nofollow noopener noreferrer" target="_blank" tabindex="-1">@icon('search', 'w-5 h-5')</a>
                </div>
            </div>
        </div>

        @if ($teams->count() > 1)

        <div class="p-2">
            <x-select name="teams[]" value="id" :text="['name']" :options="$teams->toArray()" :label="__('app-create.teams')" :selected="$REQUEST->input('teams')" class="tom-select w-full" id="app-teams" multiple required></x-select>
        </div>

        @else

        <input type="hidden" name="teams[]" value="{{ $teams->first()->id ?? '' }}" />

        @endif

        <div class="p-2">
            <x-select name="tags[]" value="id" :text="['name']" :options="$tags->toArray()" :label="__('app-create.tags')" :selected="$REQUEST->input('tags')" class="tom-select w-full" id="app-tags" data-create multiple></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        @include ('domains.app.types.'.$type.'.create')

        <div class="pr-2 text-right text-gray-600 text-xs mt-0.5">{{ __('app-create.fields-encrypted') }}</div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        <div class="lg:grid grid-cols-12 gap-6 p-2">
            @for ($i = 0; $i < 6; $i++)

            <div class="col-span-4">
                <label for="files-{{ $i }}-file" class="form-label truncate">{{ __('app-create.add-attachemnt') }}</label>

                <div class="input-group input-file-custom" data-input-file-custom>
                    <input type="file" name="files[{{ $i }}][file]" id="files-{{ $i }}-file" class="hidden" />
                    <input type="text" class="form-control form-control-lg truncate" readonly />

                    <label for="files-{{ $i }}-file" class="input-group-text input-group-text-lg border-0">@icon('upload', 'w-5 h-5')</label>
                </div>
            </div>

            @endfor
        </div>

        <div class="pr-2 text-right text-gray-600 text-xs mt-0.5">{{ __('app-update.fields-encrypted') }}</div>
    </div>

    @if (empty($AUTH->readonly))

    <div class="box p-5 mt-5">
        <div class="p-2 form-check">
            <input type="checkbox" name="shared" value="1" class="form-check-switch" id="app-shared" {{ $REQUEST->input('shared') ? 'checked' : '' }}>
            <label for="app-shared" class="form-check-label">{{ __('app-create.shared') }}</label>
        </div>

        <div class="p-2 form-check">
            <input type="checkbox" name="editable" value="1" class="form-check-switch" id="app-editable" {{ $REQUEST->input('editable') ? 'checked' : '' }}>
            <label for="app-editable" class="form-check-label">{{ __('app-create.editable') }}</label>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('app-create.save') }}</button>
        </div>
    </div>
</form>

@endif

@stop
