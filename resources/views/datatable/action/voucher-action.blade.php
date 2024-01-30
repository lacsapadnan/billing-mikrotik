@php
    $deleteUrl = route('admin:prepaid.voucher.destroy', $id);
@endphp
<div class="flex flex-row gap-2">
    <form action="{{ $deleteUrl }}" method="POST" x-data="confirmable({
        confirmTitle: 'Delete?',
        confirmButtonColor: 'var(--bs-danger)',
        onConfirm: ()=>$el.submit()
    })" @submit="confirm">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-sm btn-light-danger confirmable">
            Delete
        </button>
    </form>
</div>
