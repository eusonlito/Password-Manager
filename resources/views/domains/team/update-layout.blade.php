@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
        <a href="javascript:;" class="py-4 sm:mr-8" role="tab">{{ $row->name }}</a>
        <a href="{{ route('team.update', $row->id) }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'team.update') ? 'active' : '' }}" role="tab">{{ __('team-update.data') }}</a>
        <a href="{{ route('team.update.user', $row->id) }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'team.update.user') ? 'active' : '' }}" role="tab">{{ __('team-update.users') }}</a>
        <a href="{{ route('team.update.app', $row->id) }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'team.update.app') ? 'active' : '' }}" role="tab">{{ __('team-update.apps') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
