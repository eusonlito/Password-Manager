@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('tag-index.filter') }}" data-table-search="#tag-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('tag.create') }}" class="btn form-control-lg">{{ __('tag-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="tag-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination>
        <thead>
            <tr>
                <th class="w-1">{{ __('tag-index.id') }}</th>
                <th class="text-left">{{ __('tag-index.name') }}</th>
                <th class="text-center">{{ __('tag-index.apps') }}</th>
                <th class="text-center">{{ __('tag-index.color') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('tag.update', $row->id))

            <tr>
                <td class="w-1"><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td><a href="{{ $link }}" class="block text-left font-semibold whitespace-nowrap">{{ $row->name }}</a></td>
                <td><a href="{{ route('app.index', ['tag' => $row->code]) }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->apps_count }}</a></td>
                <td class="text-center"><a href="{{ $link }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($row->color)">{{ $row->color }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="box mt-2 p-2 text-right">
    <a href="{{ route('tag.create') }}" class="btn form-control-lg">{{ __('tag-index.create') }}</a>
</div>

@stop
