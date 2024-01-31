<head>
    @vite(['resources/css/app.css'])
    <script type="text/javascript">
        function printpage() {
            window.print();
        }
    </script>
</head>

<body topmargin="0" leftmargin="0" onload="printpage()" <div class="row">
    <div class="col-md-12">
        <table>
            <tr>
                <td width="200">
                    <fieldset>
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
                </td>
            </tr>

        </table>
    </div>
</body>

