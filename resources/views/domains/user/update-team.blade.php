@extends ('domains.user.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <form method="get">
        <div class="sm:flex sm:space-x-4">
            <div class="flex-grow mt-2 sm:mt-0">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-update-team.filter') }}" data-table-search="#user-update-team-table" />
            </div>
        </div>
    </form>
</div>

<form method="post">
    <input type="hidden" name="_action" value="updateTeam" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto md:overflow-visible header-sticky">
            <table id="user-update-team-table" class="table table-report font-medium text-center whitespace-nowrap" data-table-sort>
                <thead>
                    <tr>
                        <th class="text-left">{{ __('user-update-team.name') }}</th>
                        <th>{{ __('user-update-team.related') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($teams as $each)

                    <tr>
                        <td class="text-left">
                            <label for="team_ids-{{ $each->id }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($each->color)">{{ $each->name }}</label>
                        </td>
                        <td data-table-sort-value="{{ (int)$each->selected }}">
                            <input type="checkbox" name="team_ids[]" id="team_ids-{{ $each->id }}" value="{{ $each->id }}" {{ $each->selected ? 'checked' : '' }}/>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('user-update-team.save') }}</button>
        </div>
    </div>
</form>

@stop
