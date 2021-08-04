<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="javascript:;" id="mobile-menu-toggler">
            @icon('bar-chart-2', 'w-8 h-8 text-white transform -rotate-90')
        </a>
    </div>

    <ul class="border-t border-theme-21 py-5 hidden">
        <li>
            <a href="{{ route('app.index') }}" class="menu {{ (strpos($ROUTE, 'app.') === 0) ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('cpu')</div>
                <div class="menu__title">{{ __('in-sidebar.apps') }}</div>
            </a>
        </li>

        @if ($AUTH->admin)

        <li>
            <a href="{{ route('user.index') }}" class="menu {{ ((strpos($ROUTE, 'user.') === 0) && ($ROUTE !== 'user.profile')) ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('users')</div>
                <div class="menu__title">{{ __('in-sidebar.users') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('team.index') }}" class="menu {{ (strpos($ROUTE, 'team.') === 0) ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('briefcase')</div>
                <div class="menu__title">{{ __('in-sidebar.teams') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('log.index') }}" class="menu {{ (strpos($ROUTE, 'log.') === 0) ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('book-open')</div>
                <div class="menu__title">{{ __('in-sidebar.log') }}</div>
            </a>
        </li>

        @endif

        <li>
            <a href="{{ route('user.profile') }}" class="menu {{ ($ROUTE === 'user.profile') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('user')</div>
                <div class="menu__title">{{ __('in-sidebar.profile') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.logout') }}" class="menu">
                <div class="menu__icon">@icon('toggle-right')</div>
                <div class="menu__title">{{ __('in-sidebar.logout') }}</div>
            </a>
        </li>
    </ul>
</div>