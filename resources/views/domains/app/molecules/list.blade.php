<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="app-list-table" class="table table-report sm:mt-2 font-medium whitespace-nowrap" data-table-sort data-table-pagination>
        <thead>
            <tr>
                <th>{{ __('app-index.icon') }}</th>
                <th>{{ __('app-index.name') }}</th>
                <th>{{ __('app-index.type') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center">{{ __('app-index.tags') }}</th>
                <th class="text-center">{{ __('app-index.visibility') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                <td>
                    <a href="{{ route('app.update', $row->id) }}" class="app-logo"><img src="@image($row->icon, 'resize,0,32')" class="app-logo"></a>
                </td>

                <td class="truncate max-w-2xs">
                    <a href="{{ route('app.update', $row->id) }}">{{ $row->name }}</a>
                </td>

                <td>
                    <a href="?type={{ $row->type }}">{{ $row->typeTitle() }}</a>
                </td>

                @include ('domains.app.types.'.$row->type.'.list')

                <td class="text-center">
                    <div class="flex justify-center space-x-2">
                        @foreach ($row->tags as $each)

                        <a href="?tag={{ $each->code }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($each->color)">{{ $each->name }}</a>

                        @endforeach
                    </div>
                </td>

                <td class="text-center">
                    <span title="{{ $row->shared ? __('app-index.shared') : __('app-index.private') }}">@icon($row->shared ? 'unlock' : 'lock', 'w-4 h-4')</span>

                    @if ($row->shared)
                    <span title="{{ $row->editable ? __('app-index.editable') : __('app-index.readonly') }}">@icon($row->editable ? 'edit-2' : 'eye', 'w-4 h-4')</span>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>
