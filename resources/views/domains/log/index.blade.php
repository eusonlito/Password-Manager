@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('log-index.filter') }}" data-table-search="#log-list-table" />
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="log-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination>
        <thead>
            <tr>
                <th>{{ __('log-index.id') }}</th>
                <th>{{ __('log-index.created_at') }}</th>
                <th class="text-left">{{ __('log-index.action') }}</th>
                <th class="text-left">{{ __('log-index.payload') }}</th>
                <th class="text-left">{{ __('log-index.user') }}</th>
                <th>{{ __('log-index.app') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                <td><span class="block text-center whitespace-nowrap">{{ $row->id }}</span></td>
                <td><span class="block text-center whitespace-nowrap">@datetime($row->created_at)</span></td>
                <td><span class="block text-left whitespace-nowrap">{{ $row->action }}</span></td>
                <td><span class="block text-left whitespace-nowrap">{{ $row->payload() }}</span></td>
                <td>
                    @if ($row->userFrom)

                    <a href="{{ route('user.update', $row->userFrom->id) }}" class="block text-left whitespace-nowrap">{{ $row->userFrom->name }}</a>

                    @else

                    <span class="block text-left whitespace-nowrap">{{ $row->user_from_id }}</span>

                    @endif
                </td>
                <td>
                    @if ($row->app && $row->app->canView($AUTH))

                    <a href="{{ route('app.update', $row->app->id) }}" class="block whitespace-nowrap">{{ $row->app->name }}</a>

                    @elseif ($row->app)

                    <span title="{{ __('app-index.private') }}">@icon('lock', 'w-4 h-4')</span>

                    @else

                    <span class="block text-left whitespace-nowrap">{{ $row->app_id }}</span>

                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop