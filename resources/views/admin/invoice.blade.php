<x-admin-layout title="Invoice" active-menu="invoice" :path="['Dashboard'=>router('admin:dashboard'), 'Invoice' => '']">
<div class="row">
    <div class="col-md-6 col-sm-12 col-md-offset-3">
        <div class="panel panel-hovered panel-primary panel-stacked mb30">
            <div class="panel-heading">{{$invoice['invoice']}}</div>
            <div class="panel-body">
                <div class="well">
                    <fieldset>
                        <center>
                            <b>{{$config['CompanyName']}}</b><br>
                            {{$config['address']}}<br>
                            {{$config['phone']}}<br>
                        </center>
                        ====================================================<br>
                        INVOICE: <b>{{$invoice['invoice']}}</b> - {{__('Date')}} : {{$date}}<br>
                        {{__('Sales')}} : {{$admin['fullname']}}<br>
                        ====================================================<br>
                        {{__('Type')}} : <b>{{$invoice['type']}}</b><br>
                        {{__('Plan_Name')}} : <b>{{$invoice['plan_name']}}</b><br>
                        {{__('Plan_Price')}} : <b>{{\App\Support\Lang::moneyFormat($invoice['price'])}}</b><br>
                        {{$invoice['method']}}<br>
                        <br>
                        {{__('Username')}} : <b>{{$invoice['username']}}</b><br>
                        {{__('Password')}} : **********<br>
                        @if($invoice['type']->value != 'Balance')
                            <br>
                            {{__('Created_On')}} : <b>{{\App\Support\Lang::dateAndTimeFormat($invoice['recharged_at'])}}</b><br>
                            {{__('Expires_On')}} : <b>{{\App\Support\Lang::dateAndTimeFormat($invoice['expired_at'])}}</b><br>
                        @endif
                        =====================================================<br>
                        <center>{{$config['note']}}</center>
                    </fieldset>
                </div>
                <form class="form-horizontal" method="post" action="{$_url}prepaid/print" target="_blank">
                    <input type="hidden" name="id" value="{{$invoice['id']}}">
                    <a href="{$_url}prepaid/list" class="btn btn-primary btn-sm"><i
                            class="ion-reply-all"></i>{$_L['Finish']}</a>
                    <a href="{$_url}prepaid/view/{$invoice['id']}/send" class="btn btn-info text-black btn-sm"><i
                        class="glyphicon glyphicon-envelope"></i> {Lang::T("Resend To Customer")}</a>
                    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-print"></i>
                        {$_L['Click_Here_to_Print']}</button>
                </form>

            </div>
        </div>
    </div>
</div>
</x-admin-layout>


<script type="text/javascript">
    var s5_taf_parent = window.location;

    function popup_print() {
        window.open('print.php?page=<?php echo $_GET['
            act '];?>', 'page',
            'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=50,top=50,titlebar=yes'
            )
    }
</script>
{include file="sections/footer.tpl"}
