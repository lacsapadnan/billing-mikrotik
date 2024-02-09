@php
    $action = $mode == 'edit' ? route('admin:setting.user.update', $user) : route('admin:setting.user.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'setting.user.edit' : 'setting.user.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Administrator" :active-menu="$activeMenu" :path="['List Administrator' => route('admin:setting.user.index'), ucfirst($mode) . ' Administrator' => '']">
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
                        <input type="hidden" name="id" value="{{ $user['id'] }}" />
                    @endif
                    <x-form.group.input name="username" required :value="@$user['username']" />
                    <x-form.group.input name="fullname" required :value="@$user['fullname']" />
                    @if(@$user['id'] != auth()->user()->id)
                    <x-form.group.select name="user_type" :options="$userTypes" label="User Type" required
                        :value="@$user['user_type']?->value" />
                    @endif
                    <x-form.group.input name="password" type="password" label="Password" :required="@$mode == 'add'"/>
                    <x-form.group.input name="password_confirmation" type="password" label="Confirm Password" :required="@$mode == 'add'"/>

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
