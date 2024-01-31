<x-admin-layout title="Invoice" active-menu="invoice" :path="['Dashboard' => route('admin:dashboard'), 'Invoice' => '']">
    <div class="row app-container">
        <div class="col-md-8 col-sm-12 col-md-offset-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="my-auto">{{ $invoice['invoice'] }}</h2>
                </div>
                <div class="card-body">
                    <fieldset class="bg-light card-body card shadow-inner border mb-5">
                        <center>
                            <b>{{ $config['CompanyName'] }}</b><br>
                            {{ $config['address'] }}<br>
                            {{ $config['phone'] }}<br>
                        </center>
                        ====================================================<br>
                        INVOICE: <b>{{ $invoice['invoice'] }}</b> - {{ __('Date') }} :
                        {{ now()->format('Y-m-d H:i:s') }}<br>
                        {{ __('Sales') }} : {{ $admin['fullname'] }}<br>
                        ====================================================<br>
                        {{ __('Type') }} : <b>{{ $invoice['type'] }}</b><br>
                        {{ __('Plan_Name') }} : <b>{{ $invoice['plan_name'] }}</b><br>
                        {{ __('Plan_Price') }} :
                        <b>{{ \App\Support\Lang::moneyFormat($invoice['price']) }}</b><br>
                        {{ $invoice['method'] }}<br>
                        <br>
                        {{ __('Username') }} : <b>{{ $invoice['username'] }}</b><br>
                        {{ __('Password') }} : **********<br>
                        @if ($invoice['type']->value != 'Balance')
                            <br>
                            {{ __('Created_On') }} :
                            <b>{{ \App\Support\Lang::dateTimeFormat($invoice['recharged_at']) }}</b><br>
                            {{ __('Expires_On') }} :
                            <b>{{ \App\Support\Lang::dateTimeFormat($invoice['expired_at']) }}</b><br>
                        @endif
                        =====================================================<br>
                        <center>{{ $config['note'] }}</center>
                    </fieldset>
                    <form class="form-horizontal" action="{{ route('admin:prepaid.invoice.print', $invoice) }}"
                        target="_blank">
                        <a href="{{ route('admin:prepaid.user.index') }}"
                            class="btn btn-primary btn-sm">{{ __('Finish') }}</a>
                        {{-- <a href="{$_url}prepaid/view/{$invoice['id']}/send" class="btn btn-info text-black btn-sm"><i --}}
                        {{--     class="glyphicon glyphicon-envelope"></i> {Lang::T("Resend To Customer")}</a> --}}
                        <button type="submit" class="btn btn-light btn-sm">{{ __('Click Here to Print') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
