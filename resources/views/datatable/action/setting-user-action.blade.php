@php
    $editUrl = route('admin:setting.user.edit', $id);
    $deleteUrl = route('admin:setting.user.destroy', $id);
@endphp
<div class="flex flex-row gap-2">
    <a class="btn btn-sm btn-light-success" href="{{ $editUrl }}">edit</a>
    @if(auth()->user()->id != $id)
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
    @endif
</div>
