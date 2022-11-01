@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
        <a href="javascript:;" class="py-4 sm:mr-8" role="tab">{{ $row->name }}</a>
        <a href="{{ route('icon.update', $row->name) }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'icon.update') ? 'active' : '' }}" role="tab">{{ __('icon-update.data') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
