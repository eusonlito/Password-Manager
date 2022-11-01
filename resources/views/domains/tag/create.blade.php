@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
        <a href="javascript:;" class="py-4 sm:mr-8 active" role="tab">{{ __('tag-create.data') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        <form method="post">
            <input type="hidden" name="_action" value="create" />

            <div class="box p-5 mt-5">
                <div class="p-2">
                    <label for="tag-name" class="form-label">{{ __('tag-create.name') }}</label>
                    <input type="text" name="name" class="form-control form-control-lg" id="tag-name" value="{{ $REQUEST->input('name') }}" required>
                </div>

                <div class="p-2">
                    <label for="tag-color" class="form-label">{{ __('tag-create.color') }}</label>
                    <input type="color" name="color" class="form-control form-control-lg pt-0 pb-0" id="tag-color" value="{{ $REQUEST->input('color') }}" required>
                </div>
            </div>

            <div class="box p-5 mt-5">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ __('tag-create.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
