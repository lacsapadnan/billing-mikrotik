@php
    $detailUrl = route('admin:customer.show', $id);
@endphp
<div class="inline-flex gap-1">
    <a href="{{$detailUrl}}" class="btn btn-sm btn-success">view</a>
    <a href="#" class="btn btn-sm btn-primary">recharge</a>
</div>
