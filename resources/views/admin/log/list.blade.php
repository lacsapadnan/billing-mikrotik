<x-admin-layout title="{{ $appName }} Logs" active-menu="log.index" :path="['Activity Log' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable">
            <x-slot:filter>
                <form action="{{ route('admin:log.clean') }}" class="row" x-data="confirmable?.({
                    confirmTitle: 'Clean Logs?',
                    confirmButtonColor: 'var(--bs-danger)',
                    onConfirm: () => $el.submit()
                })" @submit="confirm"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="col-md-4 col-6 mb-4">
                        <div class="input-group mb-5">
                            <span class="input-group-text">Keep Logs</span>
                            <input type="number" class="form-control" aria-label="Keep Logs in Days" value="90"
                                name="days" />
                            @error('days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="input-group-text">Days</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6 mb-4">
                        <button type="submit" class="btn btn-danger">Clean Logs</button>
                    </div>


                </form>
            </x-slot:filter>
        </x-datatable>
    </div>
</x-admin-layout>
