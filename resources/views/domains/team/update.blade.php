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
            <label for="team-color" class="form-label">{{ __('team-update.color') }}</label>
            <input type="color" name="color" class="form-control form-control-lg pt-0 pb-0" id="team-color" value="{{ $REQUEST->input('color') }}" required>
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
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('team-update.delete.button') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('team-update.save') }}</button>
        </div>
    </div>
</form>

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('team.delete', $row->id) }}" method="post">
                    <input type="hidden" name="_action" value="delete" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                        <div class="text-3xl mt-5">{{ __('team-update.delete.title') }}</div>
                        <div class="text-gray-600 mt-2">
                            {!! __('team-update.delete.message', ['users' => $users_count, 'apps' => $apps_count]) !!}
                        </div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('team-update.delete.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('team-update.delete.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
