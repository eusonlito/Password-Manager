<div class="sm:grid grid-cols-3 gap-4 sm:h-80 content-center">
    <div class="box p-5 mt-5">
        <img src="{{ $tfa_qr }}" class="m-auto" style="width: 260px; height: 260px;">
    </div>

    <div class="box p-5 mt-5">
        <img src="@asset('build/images/google-authenticator.png')" class="m-auto" style="width: 260px; height: 260px;">
    </div>

    <div class="box p-5 mt-5">
        <div class="grid grid-rows-2 gap-2 h-full">
            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" rel="nofollow noopener noreferrer" target="_blank" class="m-auto">
                <img src="@asset('build/images/google-play-store.png')" style="height: 80px;">
            </a>

            <a href="https://apps.apple.com/es/app/google-authenticator/id388497605" rel="nofollow noopener noreferrer" target="_blank" class="m-auto">
                <img src="@asset('build/images/apple-app-store.png')" style="height: 80px;">
            </a>
        </div>
    </div>
</div>

<div class="box p-5 mt-5 text-center">
    {{ __('user-profile.tfa-description') }}
</div>

<div class="box p-5 mt-5">
    <div class="form-check">
        <input type="checkbox" name="tfa_enabled" value="1" class="form-check-switch" id="user-tfa_enabled" {{ $row->tfa_enabled ? 'checked' : '' }}>
        <label for="user-tfa_enabled" class="form-check-label">{{ __('user-profile.tfa_enabled') }}</label>
    </div>
</div>