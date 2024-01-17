@php
    $editUrl = route('admin:network.router.edit', $id);
    $deleteUrl = route('admin:network.router.destroy', $id);
@endphp
<div class="flex flex-row gap-2">
    <a class="btn btn-sm btn-light-success" href="{{ $editUrl }}">edit</a>
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
