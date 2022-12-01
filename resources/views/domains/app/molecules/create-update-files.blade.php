<div class="box p-5 mt-5 bg-green-50">
    <div class="lg:grid grid-cols-12 gap-6 p-2">
        @foreach ($files as $i => $each)

        <div class="col-span-4">
            <label for="files-{{ $i }}-file" class="form-label block truncate">{{ $each->name }}</label>

            <div class="input-group input-file-custom" data-input-file-custom>
                <input type="hidden" name="files[{{ $i }}][id]" value="{{ $each->id }}" />

                <input type="file" name="files[{{ $i }}][file]" id="files-{{ $i }}-file" class="hidden" />
                <input type="text" value="{{ $each->name }}" class="form-control form-control-lg truncate" readonly />

                <label for="files-{{ $i }}-file" class="input-group-text input-group-text-lg border-0">@icon('upload', 'w-5 h-5')</label>

                <a href="{{ route('app.file', [$row->id, $each->id]) }}" class="input-group-text input-group-text-lg" target="_blank" tabindex="-1">@icon('external-link', 'w-5 h-5')</a>

                <label class="input-group-text input-group-text-lg" title="{{ __('app-update.icon_reset') }}">
                    <input type="checkbox" name="files[{{ $i }}][delete]" value="1">
                    @icon('trash', 'ml-1 w-5 h-5')
                </label>
            </div>
        </div>

        @endforeach

        @for ($i = count($files); $i < 6; $i++)

        <div class="col-span-4">
            <label for="files-{{ $i }}-file" class="form-label block truncate">{{ __('app-create.add-attachemnt') }}</label>

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
