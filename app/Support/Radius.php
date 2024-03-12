<?php

namespace App\Support;

use App\Models\Nas;
use App\Models\RadCheck;
use App\Models\RadGroupReply;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use Timezone;

class Radius
{
    public static function getClient()
    {
        global $config;
        if (empty($config['radius_client'])) {
            if (function_exists("shell_exec")) {
                shell_exec('which radclient');
            } else {
                return "";
            }
        } else {
            $config['radius_client'];
        }
    }

    public static function getTableNas()
    {
        return Nas::get();
    }

    public static function getTableCustomer()
    {
        return RadCheck::get();
    }

    public static function getTableCustomerAttr()
    {
        return RadReply::get();
    }

    public static function getTablePackage()
    {
        return RadGroupReply::get();
    }

    public static function getTableUserPackage()
    {
        return RadUserGroup::get();
    }

    public static function nasAdd($name, $ip, $ports, $secret, $routers = "", $description = "", $type = 'other', $server = null, $community = null)
    {
        $nas = Nas::create([
            'nasname' => $ip,
            'shortname' => $name,
            'type' => $name,
            'ports' => $ports,
            'secret' => $secret,
            'description' => $description,
            'server' => $server,
            'community' => $community,
            'routers' => $routers,
        ]);

        return $nas->id;
    }

    public static function nasUpdate($id, $name, $ip, $ports, $secret, $routers = "", $description = "", $type = 'other', $server = null, $community = null)
    {
        $nas = Nas::find($id);

        if (empty($nas)) {
            return false;
        }

        $nas->update([
            'nasname' => $ip,
            'shortname' => $name,
            'type' => $type,
            'ports' => $ports,
            'secret' => $secret,
            'description' => $description,
            'server' => $server,
            'community' => $community,
            'routers' => $routers,
        ]);

        return $nas;
    }

    public static function planUpSert($plan_id, $rate, $pool = null)
    {
        $rates = explode('/', $rate);
        Radius::upsertPackage($plan_id, 'Ascend-Data-Rate', $rates[1], ':=');
        Radius::upsertPackage($plan_id, 'Ascend-Xmit-Rate', $rates[0], ':=');
        Radius::upsertPackage($plan_id, 'Mikrotik-Rate-Limit', $rate, ':=');
        // if ($pool != null) {
        //     Radius::upsertPackage($plan_id, 'Framed-Pool', $pool, ':=');
        // }
    }

    public static function planDelete($plan_id)
    {
        // Delete Plan
        RadGroupReply::where('plan_id', "plan_" . $plan_id)->delete();

        // Reset User Plan
        $c = RadUserGroup::where('groupname', "plan_" . $plan_id)->get();
        if ($c) {
            foreach ($c as $u) {
                $u->groupname = '';
                $u->save();
            }
        }
    }


    public static function customerChangeUsername($from, $to)
    {
        $c = RadCheck::where('username', $from)->get();
        if ($c) {
            foreach ($c as $u) {
                $u->username = $to;
                $u->save();
            }
        }
        $c = RadUserGroup::where('username', $from)->get();
        if ($c) {
            foreach ($c as $u) {
                $u->username = $to;
                $u->save();
            }
        }
    }

    public static function customerDeactivate($username, $radiusDisconnect = true)
    { {
            global $radius_pass;
            $r = RadCheck::where('username', $username)->where('attribute', 'Cleartext-Password')->first();
            if ($r) {
                // no need to delete, because it will make ID got higher
                // we just change the password
                $r->value = md5(time() . $username . $radius_pass);
                $r->save();
                if ($radiusDisconnect)
                    return Radius::disconnectCustomer($username);
            }
        }
        return '';
    }

    public static function customerDelete($username)
    {
        RadCheck::where('username', $username)->delete();
        RadUserGroup::where('username', $username)->delete();
    }

    /**
     * When add a plan to Customer, use this
     */
    public static function customerAddPlan($customer, $plan, $expired = null)
    {
        global $config;
        if (Radius::customerUpsert($customer, $plan)) {
            $p = RadUserGroup::where('username', $customer['username'])->first();
            if ($p) {
                // if exists
                $p->update([
                    'groupname' => "plan_" . $plan['id']
                ]);
            } else {
                $p = RadUserGroup::create([
                    'username' => $customer['username'],
                    'groupname' => "plan_" . $plan['id'],
                    'priority' => 1
                ]);
            }
            if ($plan['type'] == 'Hotspot' && $plan['typebp'] == "Limited") {
                if ($plan['limit_type'] == "Time_Limit") {
                    if ($plan['time_unit'] == 'Hrs')
                        $timelimit = $plan['time_limit'] * 60 * 60;
                    else
                        $timelimit = $plan['time_limit'] * 60;
                    Radius::upsertCustomer($customer['username'], 'Expire-After', $timelimit);
                } else if ($plan['limit_type'] == "Data_Limit") {
                    if ($plan['data_unit'] == 'GB')
                        $datalimit = $plan['data_limit'] . "000000000";
                    else
                        $datalimit = $plan['data_limit'] . "000000";
                    //Radius::upsertCustomer($customer['username'], 'Max-Volume', $datalimit);
                    // Mikrotik Spesific
                    Radius::upsertCustomer($customer['username'], 'Mikrotik-Total-Limit', $datalimit);
                } else if ($plan['limit_type'] == "Both_Limit") {
                    if ($plan['time_unit'] == 'Hrs')
                        $timelimit = $plan['time_limit'] * 60 * 60;
                    else
                        $timelimit = $plan['time_limit'] . ":00";
                    if ($plan['data_unit'] == 'GB')
                        $datalimit = $plan['data_limit'] . "000000000";
                    else
                        $datalimit = $plan['data_limit'] . "000000";
                    //Radius::upsertCustomer($customer['username'], 'Max-Volume', $datalimit);
                    Radius::upsertCustomer($customer['username'], 'Expire-After', $timelimit);
                    // Mikrotik Spesific
                    Radius::upsertCustomer($customer['username'], 'Mikrotik-Total-Limit', $datalimit);
                }
            } else {
                //Radius::delAtribute(Radius::getTableCustomer(), 'Max-Volume', 'username', $customer['username']);
                Radius::delAtribute(Radius::getTableCustomer(), 'Expire-After', 'username', $customer['username']);
                Radius::delAtribute(Radius::getTableCustomer(), 'Mikrotik-Total-Limit', 'username', $customer['username']);
            }
            // expired user
            if ($expired != null) {
                //Radius::upsertCustomer($customer['username'], 'access-period', strtotime($expired) - time());
                Radius::upsertCustomer($customer['username'], 'expiration', date('d M Y H:i:s', strtotime($expired)));
                // Mikrotik Spesific
                Radius::upsertCustomer(
                    $customer['username'],
                    'WISPr-Session-Terminate-Time',
                    date('Y-m-d', strtotime($expired)) . 'T' . date('H:i:s', strtotime($expired)) . Timezone::getTimeOffset($config['timezone'])
                );
            } else {
                //Radius::delAtribute(Radius::getTableCustomer(), 'access-period', 'username', $customer['username']);
                Radius::delAtribute(Radius::getTableCustomer(), 'expiration', 'username', $customer['username']);
            }

            if ($plan['type'] == 'PPPOE') {
                Radius::upsertCustomerAttr($customer['username'], 'Framed-Pool', $plan['pool'], ':=');
            }
            return true;
        }
        return false;
    }

    public static function customerUpsert($customer, $plan)
    {
        if ($plan['type'] == 'PPPOE') {
            Radius::upsertCustomer($customer['username'], 'Cleartext-Password', (empty($customer['pppoe_password'])) ? $customer['password'] : $customer['pppoe_password']);
        } else {
            Radius::upsertCustomer($customer['username'], 'Cleartext-Password',  $customer['password']);
        }
        Radius::upsertCustomer($customer['username'], 'Simultaneous-Use', ($plan['type'] == 'PPPOE') ? 1 : $plan['shared_users']);
        // Mikrotik Spesific
        Radius::upsertCustomer($customer['username'], 'Port-Limit', ($plan['type'] == 'PPPOE') ? 1 : $plan['shared_users']);
        Radius::upsertCustomer($customer['username'], 'Mikrotik-Wireless-Comment', $customer['fullname']);
        return true;
    }

    private static function delAtribute($tabel, $attribute, $key, $value)
    {
        $r = $tabel->where($key, $value)->where('attribute', $attribute)->first();
        if ($r) $r->delete();
    }

    /**
     * To insert or update existing plan
     */
    private static function upsertPackage($plan_id, $attr, $value, $op = ':=')
    {
        $r = RadGroupReply::where('plan_id', $plan_id)->where('attribute', $attr)->first();
        if (!$r) {
            $r = RadGroupReply::create([
                'groupname' => 'plan_' . $plan_id,
                'plan_id' => $plan_id,
            ]);
        }
        $r->update([
            'attribute' => $attr,
            'op' => $op,
            'value' => $value
        ]);

        return $r;
    }

    /**
     * To insert or update existing customer
     */
    private static function upsertCustomer($username, $attr, $value, $op = ':=')
    {
        $r = RadCheck::where('username', $username)->where('attribute', $attr)->first();
        if (!$r) {
            $r = RadCheck::create([
                'username' => $username
            ]);
        }

        $r->update([
            'attribute' => $attr,
            'op' => $op,
            'value' => $value
        ]);

        return $r;
    }
    /**
     * To insert or update existing customer Attribute
     */
    public static function upsertCustomerAttr($username, $attr, $value, $op = ':=')
    {
        $r = RadReply::where('username', $username)->where('attribute', $attr)->first();
        if (!$r) {
            $r = RadReply::create([
                'username' => $username
            ]);
        }
        $r->update([
            'attribute' => $attr,
            'op' => $op,
            'value' => $value,
        ]);

        return $r;
    }

    public static function disconnectCustomer($username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $nas = Nas::get();
        $count = count($nas) * 15;
        set_time_limit($count);
        $result = [];
        foreach ($nas as $n) {
            $port = 3799;
            if (!empty($n['ports'])) {
                $port = $n['ports'];
            }
            $result[] = $n['nasname'] . ': ' . @shell_exec("echo 'User-Name = $username' | " . Radius::getClient() . " " . trim($n['nasname']) . ":$port disconnect '" . $n['secret'] . "'");
        }
        return $result;
    }
}
