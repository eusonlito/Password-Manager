@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-index.filter') }}" data-table-search="#user-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('user.create') }}" class="btn form-control-lg">{{ __('user-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="user-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-pagination="user-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('user-index.id') }}</th>
                <th class="text-left">{{ __('user-index.name') }}</th>
                <th class="text-left">{{ __('user-index.email') }}</th>
                <th>{{ __('user-index.password_enabled') }}</th>
                <th>{{ __('user-index.certificate') }}</th>
                <th>{{ __('user-index.tfa_enabled') }}</th>
                <th>{{ __('user-index.readonly') }}</th>
                <th>{{ __('user-index.admin') }}</th>
                <th>{{ __('user-index.enabled') }}</th>
                <th>{{ __('user-index.teams') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php($link = route('user.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->email }}</a></td>
                <td data-table-sort-value="{{ (int)$row->password_enabled }}">@status($row->password_enabled)</td>
                <td data-table-sort-value="{{ (int)$row->certificate }}">@status((bool)$row->certificate)</td>
                <td data-table-sort-value="{{ (int)$row->tfa_enabled }}">@status($row->tfa_enabled)</td>
                <td data-table-sort-value="{{ (int)$row->readonly }}"><a href="{{ route('user.update.boolean', [$row->id, 'readonly']) }}" data-link-boolean="readonly">@status($row->readonly)</a></td>
                <td data-table-sort-value="{{ (int)$row->admin }}"><a href="{{ route('user.update.boolean', [$row->id, 'admin']) }}" data-link-boolean="admin">@status($row->admin)</a></td>
                <td data-table-sort-value="{{ (int)$row->enabled }}"><a href="{{ route('user.update.boolean', [$row->id, 'enabled']) }}" data-link-boolean="enabled">@status($row->enabled)</a></td>
                <td class="text-center">
                    <div class="flex justify-center space-x-2">
                        @foreach ($row->teams as $each)

                        <a href="{{ route('team.update', $each->id) }}" class="text-xs py-1 px-2 rounded-lg" style="background-color: @color($each->code)">{{ $each->name }}</a>

                        @endforeach
                    </div>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-list-table-pagination" class="pagination justify-end"></ul>
</div>

<div class="box mt-2 p-2 text-right">
    <a href="{{ route('user.create') }}" class="btn form-control-lg">{{ __('user-index.create') }}</a>
</div>

@stop