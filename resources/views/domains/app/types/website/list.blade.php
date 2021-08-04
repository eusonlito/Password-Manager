<td class="truncate max-w-2xs">
    <a href="{{ $row->payload('url', '#') }}" rel="nofollow noopener noreferrer" target="_blank">{{ $row->payload('url', '-') }}</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'user']) }}">@hidden($row->payload('user'))</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'password']) }}">@hidden($row->payload('password'))</a>
</td>
