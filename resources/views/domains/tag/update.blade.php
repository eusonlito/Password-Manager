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
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('tag-update.delete.button') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('tag-update.save') }}</button>
        </div>
    </div>
</form>

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('tag.delete', $row->id) }}" method="post">
                    <input type="hidden" name="_action" value="delete" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                        <div class="text-3xl mt-5">{{ __('tag-update.delete.title') }}</div>
                        <div class="text-gray-600 mt-2">
                            @if ($apps_count)

                            {{ __('tag-update.delete.message', ['count' => $apps_count]) }}

                            @else

                            {{ __('tag-update.delete.message-empty') }}

                            @endif
                        </div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('tag-update.delete.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('tag-update.delete.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
