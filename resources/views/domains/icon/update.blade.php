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
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('icon-update.delete.button') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('icon-update.save') }}</button>
        </div>
    </div>
</form>

@if ($apps_count)

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                    <div class="text-3xl mt-5">{{ __('icon-update.delete-apps.title') }}</div>
                    <div class="text-gray-600 mt-2">
                        {!! __('icon-update.delete-apps.message', ['apps' => $apps_count]) !!}
                    </div>
                </div>

                <div class="px-5 pb-8 text-center">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('icon-update.delete-apps.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@else

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('icon.delete', $row->name) }}" method="post">
                    <input type="hidden" name="_action" value="delete" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                        <div class="text-3xl mt-5">{{ __('icon-update.delete.title') }}</div>
                        <div class="text-gray-600 mt-2">{!! __('icon-update.delete.message') !!}
                        </div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('icon-update.delete.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('icon-update.delete.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

@stop
