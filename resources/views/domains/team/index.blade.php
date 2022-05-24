@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('team-index.filter') }}" data-table-search="#team-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('team.create') }}" class="btn form-control-lg">{{ __('team-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="team-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="w-1">{{ __('team-index.id') }}</th>
                <th class="text-left">{{ __('team-index.name') }}</th>
                <th>{{ __('team-index.default') }}</th>
                <th>{{ __('team-index.users') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php($link = route('team.update', $row->id))

            <tr>
                <td class="w-1"><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td><a href="{{ $link }}" class="block text-left font-semibold whitespace-nowrap">{{ $row->name }}</a></td>
                <td data-table-sort-value="{{ (int)$row->default }}"><a href="{{ route('team.update.boolean', [$row->id, 'default']) }}" data-link-boolean="default">@status($row->default)</a></td>
                <td>{{ $row->teams_users_count }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="box mt-2 p-2 text-right">
    <a href="{{ route('team.create') }}" class="btn form-control-lg">{{ __('team-index.create') }}</a>
</div>

@stop
