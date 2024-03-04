<x-admin-layout title="Mikrotik - Import" active-menu="setting.import-mikrotik" :path="['Import Packages and Users' => '']">
    <div class="app-container container-xxl">
        <div class="alert alert-info">
            After import, you need to configure Packages, set time limit
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white">Mikrotik Import Result</h5>
            </div>
            <div class="card-body">
                <ol>
                    @foreach ($results as $result)
                        <ul>
                            - {{ $result }}
                        </ul>
                    @endforeach
                </ol>
            </div>
            <div class="row py-5">
                <div class="col-md-9 offset-md-1">
                    <div class="d-flex">
                        <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
