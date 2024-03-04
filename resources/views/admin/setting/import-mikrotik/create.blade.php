<x-admin-layout title="Mikrotik - Import" active-menu="setting.import-mikrotik" :path="['Import Packages and Users' => '']">
    <div class="app-container container-xxl">
        <div class="alert alert-info">
            <ol class="list-decimal">
                <li>This will only import packages and users</li>
                <li>Active package will not be imported</li>
                <li>You must refill the user or User buy new package</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white">Import User and Packages from Mikrotik</h5>
            </div>
            <div class="card-body">
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{route('admin:setting.import-mikrotik.store')}}">
                    @csrf
                    <x-form.group.select name="plan_type" label="Service Type" :options="$serviceTypes" required />
                    <x-form.group.select name="router_id" label="Routers" :options="$routers" required />

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
