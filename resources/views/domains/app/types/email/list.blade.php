<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'username']) }}">{{ $row->payload('username') }}</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'password']) }}">@hidden($row->payload('password'))</a>
</td>
<td></td>
