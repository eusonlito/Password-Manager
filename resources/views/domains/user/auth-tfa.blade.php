@extends ('layouts.out')

@section ('body')

<div class="flex flex-col h-screen justify-center items-center">
    <div class="w-11/12 md:w-8/12 xl:w-2/5 bg-white bg-grey-lightest px-10 py-10 rounded shadow">
        <form method="post">
            <x-message type="error" class="mb-5" />

            <input type="hidden" name="_action" value="authTFA">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="mb-6">
                <input type="number" name="code" id="auth-code" class="border w-full p-3" step="1" minlength="6" maxlength="6" placeholder="{{ __('user-auth-tfa.code') }}" autofocus required>
            </div>

            <div class="mt-5 xl:mt-8 text-center">
                <button type="submit" class="btn btn-primary py-3 px-5 whitespace-nowrap">{{ __('user-auth-tfa.login') }}</button>
            </div>
        </form>
    </div>

    <div class="w-11/12 md:w-8/12 xl:w-2/5 bg-white bg-grey-lightest px-5 py-5 text-center rounded shadow mt-5">
        <a href="{{ route('user.logout') }}" class="btn btn-primary py-3 px-5 whitespace-nowrap">{{ __('user-auth-tfa.back') }}</a>
    </div>
</div>

@stop