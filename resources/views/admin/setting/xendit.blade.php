@php
@endphp
<x-admin-layout title="Xendit - Payment Gateway" active-menu="setting.xendit" :path="['Xendit' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body" x-data="xenditForm()" x-init="init()">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ route('admin:setting.xendit.update') }}">
                    @method('PUT')
                    @csrf
                    <x-form.group.input name="xendit_secret_key" required :value="@$xendit['xendit_secret_key']" label="Secret Key"
                        placeholder="xnd_">
                        <x-slot:description>
                            <a href="https://dashboard.xendit.co/settings/developers#api-keys">
                                https://dashboard.xendit.co/settings/developers#api-keys
                            </a>
                        </x-slot:description>
                    </x-form.group.input>
                    <x-form.group.input name="xendit_verification_token" :value="@$xendit['xendit_verification_token']"
                        label="Verification Token" placeholder="randomstring">
                        <x-slot:description>
                            <a
                                href="https://dashboard.xendit.co/settings/developers#callbacks">https://dashboard.xendit.co/settings/developers#callbacks</a>
                        </x-slot:description>
                    </x-form.group.input>
                    <x-form.group.input name="xendit_callback_url" disabled value="{{ url('/xendit/callback') }}"
                        label="Callback URL">
                        <x-slot:description>
                            <a
                                href="https://dashboard.xendit.co/settings/developers#callbacks">https://dashboard.xendit.co/settings/developers#callbacks</a>
                        </x-slot:description>
                    </x-form.group.input>
                    <x-form.row>
                        <x-form.label label="Channels" />

                        <div class="col-md-9 pt-5">
                            <div class="row g-2">
                            @foreach ($channels as $channel)
                                <div class="form-check col-4 col-md-3">
                                    <input class="form-check-input" type="checkbox"
                                        @checked(in_array($channel['id'],@$xendit['xendit_channels']))
                                        id="xendit_channel{{ $channel['id'] }}" name="xendit_channels[]"
                                        value="{{ $channel['id'] }}"/>
                                    <label class="form-check-label" for="xendit_channel{{ $channel['id'] }}"/>
                                        {{ $channel['name'] }}</label>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </x-form.row>

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
    @push('addon-script')
        <script>
            window.xenditForm = () => ({
                isLimited: false,
                isTimeLimit: false,
                isDataLimit: false,
                getPools(routerId, defaultValue) {
                    fetch("{{ route('admin:network.pool.option') }}?router_id=" + routerId)
                        .then(res => res.json())
                        .then(res => {
                            $('[name="pool_expired_id"]').empty().select2({
                                data: [{
                                    id: "",
                                    text: ""
                                }, ...Object.entries(res).map(([key, value]) => {
                                    return {
                                        id: key,
                                        text: value
                                    }
                                })]
                            }).val(defaultValue).trigger('change')
                        })
                },
                submit(e) {
                    console.log(e)
                },
                init() {
                    this.getPools($('[name="router_id"]').val(), @json($xendit['pool_expired_id'] ?? ''))
                    $('[name="router_id"]').on('change', (e) => {
                        this.getPools(e.target.value)
                    })

                    this.isLimited = $('[name="typebp"]').val() == "Limited"
                    $('[name="typebp"]').on('change', (e) => {
                        this.isLimited = e.target.value == "Limited"
                    })

                    setTimeout(() => {
                        this.setLimitOption();
                    }, 200)
                    this.$watch("isLimited", (value) => {
                        if (value) {
                            this.setLimitOption()
                        }
                    })
                },
                setLimitOption() {
                    $('[name="limit_type"]').select2()
                    $('[name="time_unit"]')?.select2()
                    $('[name="data_unit"]')?.select2()
                    this.isTimeLimit = $('[name="limit_type"]').val() == "Time_Limit" || $(
                            '[name="limit_type"]')
                        .val() == "Both_Limit"
                    this.isDataLimit = $('[name="limit_type"]').val() == "Data_Limit" || $(
                            '[name="limit_type"]')
                        .val() == "Both_Limit"
                    $('[name="limit_type"]').on('change', (e) => {
                        this.isTimeLimit = e.target.value == "Time_Limit" || e.target.value ==
                            "Both_Limit"
                        this.isDataLimit = e.target.value == "Data_Limit" || e.target.value ==
                            "Both_Limit"
                    })
                }

            })
        </script>
    @endpush
</x-admin-layout>
