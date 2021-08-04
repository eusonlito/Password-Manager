@extends ('domains.user.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <form method="get">
        <div class="sm:flex sm:space-x-4">
            <div class="flex-grow mt-2 sm:mt-0">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-update-app.filter') }}" data-table-search="#app-list-table" />
            </div>
        </div>
    </form>
</div>

@include ('domains.app.molecules.list', ['list' => $apps])

@stop
