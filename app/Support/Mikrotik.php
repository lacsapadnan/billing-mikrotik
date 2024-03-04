<?php

/**
 *  PHP Mikrotik Billing (https://github.com/hotspotbilling/phpnuxbill/)
 *  by https://t.me/ibnux
 **/

namespace App\Support;

use App\Enum\DataUnit;
use App\Enum\LimitType;
use App\Enum\PlanType;
use App\Enum\PlanTypeBp;
use App\Enum\TimeUnit;
use App\Enum\ValidityUnit;
use App\Models\Bandwidth;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use Pear2\Net\RouterOS\Client;
use Pear2\Net\RouterOS\Query;
use Pear2\Net\RouterOS\Request;

class Mikrotik
{
    public static function info($name)
    {
        return Router::where('name', $name)->first();
    }

    public static function getClient($ip, $user, $pass)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $iport = explode(':', $ip);

        return new Client($iport[0], $user, $pass, ($iport[1]) ? $iport[1] : null);
    }

    public static function isUserLogin($client, $username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot active print',
            Query::where('user', $username)
        );

        return $client->sendSync($printRequest)->getProperty('.id');
    }

    public static function logMeIn($client, $user, $pass, $ip, $mac)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ip/hotspot/active/login');
        $client->sendSync(
            $addRequest
                ->setArgument('user', $user)
                ->setArgument('password', $pass)
                ->setArgument('ip', $ip)
                ->setArgument('mac-address', $mac)
        );
    }

    public static function logMeOut($client, $user)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot active print',
            Query::where('user', $user)
        );
        $id = $client->sendSync($printRequest)->getProperty('.id');
        $removeRequest = new Request('/ip/hotspot/active/remove');
        $client->sendSync(
            $removeRequest
                ->setArgument('numbers', $id)
        );
    }

    public static function addHotspotPlan($client, $name, $sharedusers, $rate)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ip/hotspot/user/profile/add');
        $client->sendSync(
            $addRequest
                ->setArgument('name', $name)
                ->setArgument('shared-users', $sharedusers)
                ->setArgument('rate-limit', $rate)
        );
    }

    public static function setHotspotPlan($client, $name, $sharedusers, $rate)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot user profile print .proplist=.id',
            Query::where('name', $name)
        );
        $profileID = $client->sendSync($printRequest)->getProperty('.id');
        if (empty($profileID)) {
            Mikrotik::addHotspotPlan($client, $name, $sharedusers, $rate);
        } else {
            $setRequest = new Request('/ip/hotspot/user/profile/set');
            $client->sendSync(
                $setRequest
                    ->setArgument('numbers', $profileID)
                    ->setArgument('shared-users', $sharedusers)
                    ->setArgument('rate-limit', $rate)
            );
        }
    }

    public static function setHotspotExpiredPlan($client, $name, $pool)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot user profile print .proplist=.id',
            Query::where('name', $name)
        );
        $profileID = $client->sendSync($printRequest)->getProperty('.id');
        if (empty($profileID)) {
            $addRequest = new Request('/ip/hotspot/user/profile/add');
            $client->sendSync(
                $addRequest
                    ->setArgument('name', $name)
                    ->setArgument('shared-users', 3)
                    ->setArgument('address-pool', $pool)
                    ->setArgument('rate-limit', '512K/512K')
            );
        } else {
            $setRequest = new Request('/ip/hotspot/user/profile/set');
            $client->sendSync(
                $setRequest
                    ->setArgument('numbers', $profileID)
                    ->setArgument('shared-users', 3)
                    ->setArgument('address-pool', $pool)
                    ->setArgument('rate-limit', '512K/512K')
            );
        }
    }

    public static function removeHotspotPlan($client, $name)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot user profile print .proplist=.id',
            Query::where('name', $name)
        );
        $profileID = $client->sendSync($printRequest)->getProperty('.id');

        $removeRequest = new Request('/ip/hotspot/user/profile/remove');
        $client->sendSync(
            $removeRequest
                ->setArgument('numbers', $profileID)
        );
    }

    public static function removeHotspotUser($client, $username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip hotspot user print .proplist=.id',
            Query::where('name', $username)
        );
        $userID = $client->sendSync($printRequest)->getProperty('.id');
        $removeRequest = new Request('/ip/hotspot/user/remove');
        $client->sendSync(
            $removeRequest
                ->setArgument('numbers', $userID)
        );
    }

    public static function addHotspotUser(Client $client, Plan $plan, Customer $customer)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ip/hotspot/user/add');
        if ($plan['typebp'] == PlanTypeBp::LIMITED) {
            if ($plan['limit_type'] == LimitType::TIME_LIMIT) {
                if ($plan['time_unit'] == TimeUnit::HRS) {
                    $timelimit = $plan['time_limit'].':00:00';
                } else {
                    $timelimit = '00:'.$plan['time_limit'].':00';
                }
                $client->sendSync(
                    $addRequest
                        ->setArgument('name', $customer['username'])
                        ->setArgument('profile', $plan['name'])
                        ->setArgument('password', $customer['password'])
                        ->setArgument('comment', $customer['fullname'])
                        ->setArgument('email', $customer['email'])
                        ->setArgument('limit-uptime', $timelimit)
                );
            } elseif ($plan['limit_type'] == LimitType::DATA_LIMIT) {
                if ($plan['data_unit'] == DataUnit::GB) {
                    $datalimit = $plan['data_limit'].'000000000';
                } else {
                    $datalimit = $plan['data_limit'].'000000';
                }
                $client->sendSync(
                    $addRequest
                        ->setArgument('name', $customer['username'])
                        ->setArgument('profile', $plan['name'])
                        ->setArgument('password', $customer['password'])
                        ->setArgument('comment', $customer['fullname'])
                        ->setArgument('email', $customer['email'])
                        ->setArgument('limit-bytes-total', $datalimit)
                );
            } elseif ($plan['limit_type'] == LimitType::BOTH_LIMIT) {
                if ($plan['time_unit'] == TimeUnit::HRS) {
                    $timelimit = $plan['time_limit'].':00:00';
                } else {
                    $timelimit = '00:'.$plan['time_limit'].':00';
                }
                if ($plan['data_unit'] == DataUnit::GB) {
                    $datalimit = $plan['data_limit'].'000000000';
                } else {
                    $datalimit = $plan['data_limit'].'000000';
                }
                $client->sendSync(
                    $addRequest
                        ->setArgument('name', $customer['username'])
                        ->setArgument('profile', $plan['name'])
                        ->setArgument('password', $customer['password'])
                        ->setArgument('comment', $customer['fullname'])
                        ->setArgument('email', $customer['email'])
                        ->setArgument('limit-uptime', $timelimit)
                        ->setArgument('limit-bytes-total', $datalimit)
                );
            }
        } else {
            $client->sendSync(
                $addRequest
                    ->setArgument('name', $customer['username'])
                    ->setArgument('profile', $plan['name'])
                    ->setArgument('comment', $customer['fullname'])
                    ->setArgument('email', $customer['email'])
                    ->setArgument('password', $customer['password'])
            );
        }
    }

    public static function setHotspotUser($client, $user, $pass)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(Query::where('name', $user));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new Request('/ip/hotspot/user/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('password', $pass);
        $client->sendSync($setRequest);
    }

    public static function setHotspotUserPackage(Client $client, string $user, string $plan)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(Query::where('name', $user));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new Request('/ip/hotspot/user/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('profile', $plan);
        $client->sendSync($setRequest);
    }

    public static function removeHotspotActiveUser($client, $username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $onlineRequest = new Request('/ip/hotspot/active/print');
        $onlineRequest->setArgument('.proplist', '.id');
        $onlineRequest->setQuery(Query::where('user', $username));
        $id = $client->sendSync($onlineRequest)->getProperty('.id');

        $removeRequest = new Request('/ip/hotspot/active/remove');
        $removeRequest->setArgument('numbers', $id);
        $client->sendSync($removeRequest);
    }

    public static function removePpoeUser($client, $username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request('/ppp/secret/print');
        //$printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(Query::where('name', $username));
        $id = $client->sendSync($printRequest)->getProperty('.id');
        $removeRequest = new Request('/ppp/secret/remove');
        $removeRequest->setArgument('numbers', $id);
        $client->sendSync($removeRequest);
    }

    public static function addPpoeUser(Client $client, Plan $plan, Customer $customer)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ppp/secret/add');
        if (! empty($customer['pppoe_password'])) {
            $pass = $customer['pppoe_password'];
        } else {
            $pass = $customer['password'];
        }
        $client->sendSync(
            $addRequest
                ->setArgument('name', $customer['username'])
                ->setArgument('service', 'pppoe')
                ->setArgument('profile', $plan['name_plan'])
                ->setArgument('comment', $customer['fullname'].' | '.$customer['email'])
                ->setArgument('password', $pass)
        );
    }

    public static function setPpoeUser($client, $user, $pass)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request('/ppp/secret/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(Query::where('name', $user));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new Request('/ppp/secret/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('password', $pass);
        $client->sendSync($setRequest);
    }

    public static function setPpoeUserPlan($client, $user, $plan)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request('/ppp/secret/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(Query::where('name', $user));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new Request('/ppp/secret/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('profile', $plan);
        $client->sendSync($setRequest);
    }

    public static function removePpoeActive($client, $username)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $onlineRequest = new Request('/ppp/active/print');
        $onlineRequest->setArgument('.proplist', '.id');
        $onlineRequest->setQuery(Query::where('name', $username));
        $id = $client->sendSync($onlineRequest)->getProperty('.id');

        $removeRequest = new Request('/ppp/active/remove');
        $removeRequest->setArgument('numbers', $id);
        $client->sendSync($removeRequest);
    }

    public static function removePool($client, $name)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip pool print .proplist=.id',
            Query::where('name', $name)
        );
        $poolID = $client->sendSync($printRequest)->getProperty('.id');

        $removeRequest = new Request('/ip/pool/remove');
        $client->sendSync(
            $removeRequest
                ->setArgument('numbers', $poolID)
        );
    }

    public static function addPool(Client $client, $name, $ip_address)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ip/pool/add');
        $client->sendSync(
            $addRequest
                ->setArgument('name', $name)
                ->setArgument('ranges', $ip_address)
        );
    }

    public static function setPool(Client $client, $name, $ip_address)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ip pool print .proplist=.id',
            Query::where('name', $name)
        );
        $poolID = $client->sendSync($printRequest)->getProperty('.id');

        if (empty($poolID)) {
            self::addPool($client, $name, $ip_address);
        } else {
            $setRequest = new Request('/ip/pool/set');
            $client->sendSync(
                $setRequest
                    ->setArgument('numbers', $poolID)
                    ->setArgument('ranges', $ip_address)
            );
        }
    }

    public static function addPpoePlan($client, $name, $pool, $rate)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $addRequest = new Request('/ppp/profile/add');
        $client->sendSync(
            $addRequest
                ->setArgument('name', $name)
                ->setArgument('local-address', $pool)
                ->setArgument('remote-address', $pool)
                ->setArgument('rate-limit', $rate)
        );
    }

    public static function setPpoePlan($client, $name, $pool, $rate)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ppp profile print .proplist=.id',
            Query::where('name', $name)
        );
        $profileID = $client->sendSync($printRequest)->getProperty('.id');
        if (empty($profileID)) {
            self::addPpoePlan($client, $name, $pool, $rate);
        } else {
            $setRequest = new Request('/ppp/profile/set');
            $client->sendSync(
                $setRequest
                    ->setArgument('numbers', $profileID)
                    ->setArgument('local-address', $pool)
                    ->setArgument('remote-address', $pool)
                    ->setArgument('rate-limit', $rate)
            );
        }
    }

    public static function removePpoePlan($client, $name)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $printRequest = new Request(
            '/ppp profile print .proplist=.id',
            Query::where('name', $name)
        );
        $profileID = $client->sendSync($printRequest)->getProperty('.id');

        $removeRequest = new Request('/ppp/profile/remove');
        $client->sendSync(
            $removeRequest
                ->setArgument('numbers', $profileID)
        );
    }

    public static function sendSMS($client, $to, $message)
    {
        global $_app_stage;
        if ($_app_stage == 'demo') {
            return null;
        }
        $smsRequest = new Request('/tool sms send');
        $smsRequest
            ->setArgument('phone-number', $to)
            ->setArgument('message', $message);
        $client->sendSync($smsRequest);
    }

    public static function importHotspot(Router $router)
    {

        $client = Mikrotik::getClient($router->ip_address, $router->username, $router->password);
        // import Hotspot Profile to package
        $printRequest = new Request(
            '/ip hotspot user profile print'
        );
        $results = [];
        $profiles = $client->sendSync($printRequest)->toArray();
        foreach ($profiles as $p) {
            $name = $p->getProperty('name');
            $rateLimit = $p->getProperty('rate-limit');
            $sharedUser = $p->getProperty('shared-user');

            // 10M/10M
            $rateLimit = explode(' ', $rateLimit)[0];
            if (strlen($rateLimit) > 1) {
                // Create Bandwidth profile
                $rate = explode('/', $rateLimit);
                $unit_up = preg_replace('/[^a-zA-Z]+/', '', $rate[0]).'bps';
                $unit_down = preg_replace('/[^a-zA-Z]+/', '', $rate[1]).'bps';
                $rate_up = preg_replace('/[^0-9]+/', '', $rate[0]);
                $rate_down = preg_replace('/[^0-9]+/', '', $rate[1]);
                $bw_name = str_replace('/', '_', $rateLimit);
                $bw = Bandwidth::where('name_bw', $bw_name)->first();
                if (! $bw) {
                    $results[] = "Bandwith Created: $bw_name";
                    $d = new Bandwidth;
                    $d->name_bw = $bw_name;
                    $d->rate_down = (int) $rate_down;
                    $d->rate_down_unit = $unit_down;
                    $d->rate_up = $rate_up;
                    $d->rate_up_unit = $unit_up;
                    $d->save();
                    $bw_id = $d->id;
                } else {
                    $results[] = "Bandwith Exists: $bw_name";
                    $bw_id = $bw->id;
                }

                // Create Packages
                $pack = Plan::where('name', $name)->first();
                if (! $pack) {
                    $results[] = "Packages Created: $name";
                    $d = new Plan;
                    $d->name = $name;
                    $d->bandwidth_id = $bw_id;
                    $d->price = '10000';
                    $d->type = PlanType::HOTSPOT;
                    $d->typebp = PlanTypeBp::UNLIMITED;
                    $d->limit_type = LimitType::TIME_LIMIT;
                    $d->time_limit = 0;
                    $d->time_unit = TimeUnit::HRS;
                    $d->data_limit = 0;
                    $d->data_unit = DataUnit::MB;
                    $d->validity = '30';
                    $d->validity_unit = ValidityUnit::DAYS;
                    $d->shared_users = $sharedUser;
                    $d->router_id = $router->id;
                    $d->enabled = 1;
                    $d->save();
                } else {
                    $results[] = "Packages Exists: $name";
                }
            }
        }
        // Import user
        $userRequest = new Request(
            '/ip hotspot user print'
        );
        $users = $client->sendSync($userRequest)->toArray();
        foreach ($users as $u) {
            $username = $u->getProperty('name');
            if (! empty($username) && ! empty($u->getProperty('password'))) {
                $d = Customer::where('username', $username)->first();
                if ($d) {
                    $results[] = "Username Exists: $username";
                } else {
                    $d = new Customer;
                    $d->username = $username;
                    $d->password = $u->getProperty('password');
                    $d->pppoe_password = $d->password;
                    $d->fullname = $username;
                    $d->address = '';
                    $d->email = (empty($u->getProperty('email'))) ? '' : $u->getProperty('email');
                    $d->phonenumber = '';
                    if ($d->save()) {
                        $results[] = "$username added successfully";
                    } else {
                        $results[] = "$username Failed to be added";
                    }
                }
            }
        }

        return $results;
    }

    public static function importPPPOE(Router $router)
    {

        $client = Mikrotik::getClient($router->ip_address, $router->username, $router->password);
        // import Hotspot Profile to package
        $printRequest = new Request(
            '/ppp profile print'
        );
        $results = [];
        $profiles = $client->sendSync($printRequest)->toArray();
        foreach ($profiles as $p) {
            $name = $p->getProperty('name');
            $rateLimit = $p->getProperty('rate-limit');

            // 10M/10M
            $rateLimit = explode(' ', $rateLimit)[0];
            if (strlen($rateLimit) > 1) {
                // Create Bandwidth profile
                $rate = explode('/', $rateLimit);
                $unit_up = preg_replace('/[^a-zA-Z]+/', '', $rate[0]).'bps';
                $unit_down = preg_replace('/[^a-zA-Z]+/', '', $rate[1]).'bps';
                $rate_up = preg_replace('/[^0-9]+/', '', $rate[0]);
                $rate_down = preg_replace('/[^0-9]+/', '', $rate[1]);
                $bw_name = str_replace('/', '_', $rateLimit);
                $bw = Bandwidth::where('name_bw', $bw_name)->first();
                if (! $bw) {
                    $results[] = "Bandwith Created: $bw_name";
                    $d = new Bandwidth;
                    $d->name_bw = $bw_name;
                    $d->rate_down = $rate_down;
                    $d->rate_down_unit = $unit_down;
                    $d->rate_up = $rate_up;
                    $d->rate_up_unit = $unit_up;
                    $d->save();
                    $bw_id = $d->id;
                } else {
                    $results[] = "Bandwith Exists: $bw_name";
                    $bw_id = $bw->id;
                }

                // Create Packages
                $pack = Plan::where('name', $name)->first();
                if (! $pack) {
                    $results[] = "Packages Created: $name";
                    $d = new Plan;
                    $d->name = $name;
                    $d->bandwidth_id = $bw_id;
                    $d->price = '10000';
                    $d->type = PlanType::PPPOE;
                    $d->typebp = PlanTypeBp::UNLIMITED;
                    $d->limit_type = LimitType::TIME_LIMIT;
                    $d->time_limit = 0;
                    $d->time_unit = TimeUnit::HRS;
                    $d->data_limit = 0;
                    $d->data_unit = DataUnit::MB;
                    $d->validity = '30';
                    $d->validity_unit = ValidityUnit::DAYS;
                    $d->router_id = $router->id;
                    $d->enabled = 1;
                    $d->save();
                } else {
                    $results[] = "Packages Exists: $name";
                }
            }
        }
        // Import user
        $userRequest = new Request(
            '/ppp secret print'
        );
        $users = $client->sendSync($userRequest)->toArray();
        foreach ($users as $u) {
            $username = $u->getProperty('name');
            if (! empty($username) && ! empty($u->getProperty('password'))) {
                $d = Customer::where('username', $username)->first();
                if ($d) {
                    $results[] = "Username Exists: $username";
                } else {
                    $d = new Customer;
                    $d->username = $username;
                    $d->password = $u->getProperty('password');
                    $d->pppoe_password = $d->password;
                    $d->fullname = $username;
                    $d->address = '';
                    $d->email = '';
                    $d->phonenumber = '';
                    if ($d->save()) {
                        $results[] = "$username added successfully";
                    } else {
                        $results[] = "$username Failed to be added";
                    }
                }
            }
        }

        return $results;
    }
}
