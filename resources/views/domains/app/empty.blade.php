@extends ('layouts.in')

@section ('body')

<div class="container p-10 mx-auto flex flex-wrap flex-col md:flex-row items-center">
    <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
        <h1 class="my-4 text-3xl md:text-5xl font-bold leading-tight text-center md:text-left">{{ __('app-empty.title', ['name' => $AUTH->name]) }}</h1>
        <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left">
            <a href="{{ route('app.create') }}">{!! __('app-empty.text') !!}</a>
        </p>
    </div>

    <div class="w-full xl:w-3/5 py-6 overflow-y-hidden">
        <img class="w-5/6 mx-auto lg:mr-0 slide-in-bottom" src="@asset('build/images/devices.svg')">
    </div>
</div>

@stop