<nav class="side-nav pt-10 pb-10">
    <ul>
        <li>
            <a href="{{ route('app.index') }}" class="side-menu {{ (strpos($ROUTE, 'app.') === 0) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('cpu')</div>
                <div class="side-menu__title">{{ __('in-sidebar.apps') }}</div>
            </a>
        </li>

        @if ($AUTH->admin)

        <li>
            <a href="{{ route('tag.index') }}" class="side-menu {{ (strpos($ROUTE, 'tag.') === 0) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('tag')</div>
                <div class="side-menu__title">{{ __('in-sidebar.tags') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.index') }}" class="side-menu {{ ((strpos($ROUTE, 'user.') === 0) && ($ROUTE !== 'user.profile')) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('users')</div>
                <div class="side-menu__title">{{ __('in-sidebar.users') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('team.index') }}" class="side-menu {{ (strpos($ROUTE, 'team.') === 0) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('briefcase')</div>
                <div class="side-menu__title">{{ __('in-sidebar.teams') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('log.index') }}" class="side-menu {{ (strpos($ROUTE, 'log.') === 0) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('book-open')</div>
                <div class="side-menu__title">{{ __('in-sidebar.log') }}</div>
            </a>
        </li>

        @endif

        <li>
            <a href="{{ route('user.profile') }}" class="side-menu {{ ($ROUTE === 'user.profile') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('user')</div>
                <div class="side-menu__title">{{ __('in-sidebar.profile') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.logout') }}" class="side-menu">
                <div class="side-menu__icon">@icon('toggle-right')</div>
                <div class="side-menu__title">{{ __('in-sidebar.logout') }}</div>
            </a>
        </li>
    </ul>
</nav>
