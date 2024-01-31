<x-admin-layout title="Period Reports" active-menu="report.peroid" :path="['Period Reports' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable">
            <x-slot:filter>
                <form action="{{ route('admin:report.period') }}" method="get" class="row" x-data="periodForm()" x-ref="form">
                    <div class="col-md-4 col-6 row mb-4">
                        <x-form.label label="From" />
                        <x-form.input name="from" type="date" @change="submit()" x-model="input['from']"/>
                    </div>
                    <div class="col-md-4 col-6 row mb-4">
                        <x-form.label label="To" />
                        <x-form.input name="to" type="date" @change="submit()" x-model="input['to']"/>
                    </div>
                    <div class="col-md-4 row mb-4">
                        <x-form.label label="Type" />
                        <x-form.select name="type" :options="$transactionTypes" @change="submit()" :select2="false" x-model="input['type']"/>
                    </div>
                </form>
            </x-slot:filter>
        </x-datatable>
        <div class="text-info text-center py-4">All transactions at Date {{ \App\Support\Lang::dateTimeFormat(now()) }}
        </div>
    </div>
    @push('addon-script')
        <script>
            window.periodForm = () => ({
                input: {
                    from: @json($defaultFrom),
                    to: @json($defaultTo),
                    type: @json($defaultType)
                },
                submit(){
                    if(this.input.from && this.input.to){
                        this.$refs.form.submit()
                    }
                }
            })
        </script>
    @endpush
</x-admin-layout>
