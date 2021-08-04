<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'number']) }}">@hidden($row->payload('number'))</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'pin']) }}">@hidden($row->payload('pin'))</a>
</td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'puk']) }}">@hidden($row->payload('puk'))</a>
</td>
