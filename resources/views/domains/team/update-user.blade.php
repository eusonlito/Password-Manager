@extends ('domains.team.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <form method="get">
        <div class="sm:flex sm:space-x-4">
            <div class="flex-grow mt-2 sm:mt-0">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('team-update-user.filter') }}" data-table-search="#team-update-user-table" />
            </div>
        </div>
    </form>
</div>

<form method="post">
    <input type="hidden" name="_action" value="updateUser" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto md:overflow-visible header-sticky">
            <table id="team-update-user-table" class="table table-report font-medium text-center whitespace-nowrap" data-table-sort>
                <thead>
                    <tr>
                        <th class="text-left">{{ __('team-update-user.name') }}</th>
                        <th class="text-left">{{ __('team-update-user.email') }}</th>
                        <th>{{ __('team-update-user.readonly') }}</th>
                        <th>{{ __('team-update-user.admin') }}</th>
                        <th>{{ __('team-update-user.enabled') }}</th>
                        <th>{{ __('team-update-user.teams') }}</th>
                        <th>{{ __('team-update-user.related') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $each)

                    <tr>
                        <td class="text-left"><span class="block font-semibold whitespace-nowrap">{{ $each->name }}</span></td>
                        <td class="text-left"><span class="block font-semibold whitespace-nowrap">{{ $each->email }}</span></td>
                        <td>@status($each->readonly)</td>
                        <td>@status($each->admin)</td>
                        <td>@status($each->enabled)</td>
                        <td>
                            <div class="flex justify-center space-x-2">
                                @foreach ($each->teams as $team)

                                <a href="{{ route('team.update', $team->id) }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($team->color)">{{ $team->name }}</a>

                                @endforeach
                            </div>
                        </td>
                        <td data-table-sort-value="{{ (int)$each->selected }}">
                            <input type="checkbox" name="user_ids[]" value="{{ $each->id }}" {{ $each->selected ? 'checked' : '' }}/>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('team-update-user.save') }}</button>
        </div>
    </div>
</form>

@stop
