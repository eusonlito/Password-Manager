@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
        <a href="{{ route('user.profile') }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'user.profile') ? 'active' : '' }}" role="tab">{{ __('user-profile.data') }}</a>

        @if ($tfa_enabled)
        <a href="{{ route('user.profile.tfa') }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'user.profile.tfa') ? 'active' : '' }}" role="tab">{{ __('user-profile.tfa') }}</a>
        @endif

        <a href="{{ route('app.export') }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'app.export') ? 'active' : '' }}" role="tab">{{ __('user-profile.export') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" tab="tabpanel">
        @yield('content')
    </div>
</div>

@stop
