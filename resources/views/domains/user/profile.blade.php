@extends ('layouts.in')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="profile" />

    <div class="box flex items-center px-5">
        <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
            <a href="javascript:;" data-toggle="tab" data-target="#profile-data" class="py-4 sm:mr-8 active" role="tab">{{ __('user-profile.data') }}</a>

            @if ($tfa_enabled)
            <a href="javascript:;" data-toggle="tab" data-target="#profile-tfa" class="py-4 sm:mr-8" role="tab">{{ __('user-profile.tfa') }}</a>
            @endif
        </div>
    </div>

    <div class="tab-content">
        <div id="profile-data" class="tab-pane active" role="tabpanel">
            @include ('domains.user.molecules.profile-data')
        </div>

        @if ($tfa_enabled)

        <div id="profile-tfa" class="tab-pane" role="tabpanel">
            @include ('domains.user.molecules.profile-tfa')
        </div>

        @endif
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('user-profile.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('user-profile.save') }}</button>
        </div>
    </div>
</form>

@stop
