<td></td>
<td></td>
<td>
    <a href="javascript:;" class="tooltip" title="{{ __('common.copy') }}" data-tippy-content="{{ __('common.copied') }}" data-copy-ajax="{{ route('app.payload.key', [$row->id, 'text']) }}">{{ strlen($row->payload('text')) ? '*********' : '' }}</a>
</td>
