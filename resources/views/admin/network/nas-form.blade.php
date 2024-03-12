@php
    $action = $mode == 'edit' ? route('admin:network.nas.update', $nas) : route('admin:network.nas.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'network.nas.edit' : 'network.nas.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Network Acess Server" :active-menu="$activeMenu" :path="['List NAS' => route('admin:network.nas.index'), ucfirst($mode) . ' NAS' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">

                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $nas['id'] }}" />
                    @endif
                    <x-form.group.input name="nasname" required :value="@$nas['nasname']" label="IP Address"
                        tooltip="IP Address of the NAS" />
                    <x-form.group.input name="shortname" required :value="@$nas['shortname']" label="Short Name" />
                    <x-form.group.input name="type" required :value="@$nas['type']" label="Type" />
                    <x-form.group.input name="ports" required type="number" :value="@$nas['ports']" label="Ports" />
                    <x-form.group.input name="secret" required type="password" :value="@$nas['secret']" label="NAS Secret" />
                    <x-form.group.input name="server" required :value="@$nas['server']" />
                    <x-form.group.input name="community" required :value="@$nas['community']" />
                    <x-form.group.input name="description" type="textarea" :value="@$nas['description']" />
                    <x-form.group.select name="routers" label="Router" :options="$routers" required
                        :value="@$pool['router_name'] ?? @$defaultRouterId" />

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</x-admin-layout>