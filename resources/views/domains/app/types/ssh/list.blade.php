<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'password']) }}">@hidden($row->payload('password'))</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'public']) }}">@hidden($row->payload('public'))</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'private']) }}">@hidden($row->payload('private'))</a>
</td>
