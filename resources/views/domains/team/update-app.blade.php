@extends ('domains.team.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <form method="get">
        <div class="sm:flex sm:space-x-4">
            <div class="flex-grow mt-2 sm:mt-0">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('team-update-app.filter') }}" data-table-search="#team-update-app-table" />
            </div>
        </div>
    </form>
</div>

<form method="post">
    <input type="hidden" name="_action" value="updateApp" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto md:overflow-visible">
            <table id="team-update-app-table" class="table table-report font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination>
                <thead>
                    <tr>
                        <th class="text-left">{{ __('team-update-app.icon') }}</th>
                        <th class="text-left">{{ __('team-update-app.name') }}</th>
                        <th>{{ __('team-update-app.type') }}</th>
                        <th>{{ __('team-update-app.teams') }}</th>
                        <th>{{ __('team-update-app.related') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($apps as $each)

                    <tr>
                        <td class="text-left">
                            <a href="{{ route('app.update', $each->id) }}" class="app-logo"><img src="@image($each->icon, 'resize,0,32')" class="app-logo"></a>
                        </td>

                        <td class="truncate max-w-2xs text-left">
                            <a href="{{ route('app.update', $each->id) }}">{{ $each->name }}</a>
                        </td>

                        <td>
                            <a href="?type={{ $each->type }}">{{ $each->typeTitle() }}</a>
                        </td>

                        <td>
                            <div class="flex justify-center space-x-2">
                                @foreach ($each->teams as $team)

                                <a href="{{ route('team.update', $team->id) }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($team->color)">{{ $team->name }}</a>

                                @endforeach
                            </div>
                        </td>

                        <td data-table-sort-value="{{ (int)$each->selected }}">
                            <input type="checkbox" name="app_ids[]" value="{{ $each->id }}" {{ $each->selected ? 'checked' : '' }}/>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('team-update-app.save') }}</button>
        </div>
    </div>
</form>

@stop
