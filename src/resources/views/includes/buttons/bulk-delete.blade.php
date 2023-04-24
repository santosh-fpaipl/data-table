{{-- 
  $style : Class name
  $bulkDisabled : Control enable and disable of button
  $feature['function'] : Function name
--}}
<button type="button" class="btn btn-primary {{ $feature['style'] }} @if ($bulkDisabled) disabled @endif"
    wire:click="{{ $feature['function'] }}">Bulk Delete
</button>
