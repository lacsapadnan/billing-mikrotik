<?php

namespace App\Support;

use App\Enum\PlanType;
use App\Enum\RechargeGateway;
use App\Enum\ValidityUnit;
use App\Exceptions\PackageRechargeException;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use App\Models\Transaction;
use App\Models\UserRecharge;

class Package
{
    public static function rechargeUser(Customer $customer, Router $mikrotik, Plan $plan, RechargeGateway $gateway, string $channel)
    {
        $date_now = now();
        $userRecharge = UserRecharge::where([
            'customer_id' => $customer->id,
            'router_id' => $mikrotik->id,
        ])->first();
        $date_exp = match ($plan->validity_unit) {
            ValidityUnit::MONTHS => now()->addMonths($plan->validity),
            ValidityUnit::DAYS => now()->addDays($plan->validity),
            ValidityUnit::HRS => now()->addHours($plan->validity),
            ValidityUnit::MINS => now()->addMinutes($plan->validity),
            default => throw new PackageRechargeException('Invalid validity unit')
        };

        if ($plan->type == PlanType::HOTSPOT) {
            if ($userRecharge) {
                if ($plan->is_radius) {
                    //TODO: radues add customer plan
                } else {
                    $client = static::resetCustomerMikrotik($mikrotik, $customer);
                    Mikrotik::addHotspotUser($client, $plan, $customer);
                }

                if ($userRecharge->namebp == $plan->name && $userRecharge->is_active) {
                    // if it same internet plan, expired will extend
                    $date_exp = match ($plan->validity_unit) {
                        ValidityUnit::MONTHS => $userRecharge->expired_at->addMonths($plan->validity),
                        ValidityUnit::DAYS => $userRecharge->expired_at->addDays($plan->validity),
                        ValidityUnit::HRS => $userRecharge->expired_at->addHours($plan->validity),
                        ValidityUnit::MINS => $userRecharge->expired_at->addMinutes($plan->validity),
                        default => throw new PackageRechargeException('Invalid validity unit')
                    };
                }

                $userRecharge->customer_id = $customer->id;
                $userRecharge->username = $customer->username;
                $userRecharge->plan_id = $plan->id;
                $userRecharge->namebp = $plan->name;
                $userRecharge->recharged_at = $date_now;
                $userRecharge->expired_at = $date_exp;
                $userRecharge->status = 'on';
                $userRecharge->method = "$gateway->value - $channel";
                $userRecharge->router_id = $mikrotik->id;
                $userRecharge->type = PlanType::HOTSPOT;
                $userRecharge->save();

                Transaction::create([
                    'invoice' => 'INV-'.Package::_raid(5),
                    'username' => $customer->username,
                    'plan_name' => $plan->name,
                    'price' => $plan->price,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'method' => "$gateway->value - $channel",
                    'routers' => $mikrotik->name,
                    'type' => PlanType::HOTSPOT,
                ]);
            } else {
                if ($plan->is_radius) {
                    // TODO: radius add customer plan
                } else {
                    $client = static::resetCustomerMikrotik($mikrotik, $customer);
                    Mikrotik::addHotspotUser($client, $plan, $customer);
                }

                UserRecharge::create([
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'plan_id' => $plan->id,
                    'namebp' => $plan->name,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'status' => 'on',
                    'method' => "$gateway->value - $channel",
                    'router_id' => $mikrotik->id,
                    'type' => PlanType::HOTSPOT,
                ]);

                Transaction::create([
                    'invoice' => 'INV-'.Package::_raid(5),
                    'username' => $customer->username,
                    'plan_name' => $plan->name,
                    'price' => $plan->price,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'method' => "$gateway->value - $channel",
                    'routers' => $mikrotik->name,
                    'type' => PlanType::HOTSPOT,
                ]);
            }
        // end if type hotspot
        } else {
            if ($userRecharge) {
                if ($plan->is_radius) {
                    // TODO: radues customer add plan
                } else {
                    $client = static::resetCustomerMikrotik($mikrotik, $customer);
                    Mikrotik::addPpoeUser($client, $plan, $customer);
                }

                if ($userRecharge->namebp == $plan->name && $userRecharge->is_active) {
                    // if it same internet plan, extend the expiration
                    $date_exp = match ($plan->validity_unit) {
                        ValidityUnit::MONTHS => $userRecharge->expired_at->addMonths($plan->validity),
                        ValidityUnit::DAYS => $userRecharge->expired_at->addDays($plan->validity),
                        ValidityUnit::HRS => $userRecharge->expired_at->addHours($plan->validity),
                        ValidityUnit::MINS => $userRecharge->expired_at->addMinutes($plan->validity),
                        default => throw new PackageRechargeException('Invalid validity unit')
                    };
                }

                $userRecharge->customer_id = $customer->id;
                $userRecharge->username = $customer->username;
                $userRecharge->plan_id = $plan->id;
                $userRecharge->namebp = $plan->name;
                $userRecharge->recharged_at = $date_now;
                $userRecharge->expired_at = $date_exp;
                $userRecharge->status = 'on';
                $userRecharge->method = "$gateway->value - $channel";
                $userRecharge->router_id = $mikrotik->id;
                $userRecharge->type = PlanType::PPPOE;
                $userRecharge->save();

                Transaction::create([
                    'invoice' => 'INV-'.Package::_raid(5),
                    'username' => $customer->username,
                    'plan_name' => $plan->name,
                    'price' => $plan->price,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'method' => "$gateway->value - $channel",
                    'routers' => $mikrotik->name,
                    'type' => PlanType::PPPOE,
                ]);
            } else {
                // if empty $userRecharge
                if ($plan->is_radius) {
                    //TODO: radues customer add plan
                } else {
                    $client = static::resetCustomerMikrotik($mikrotik, $customer);
                    Mikrotik::addPpoeUser($client, $plan, $customer);
                }

                UserRecharge::create([
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'plan_id' => $plan->id,
                    'namebp' => $plan->name,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'status' => 'on',
                    'method' => "$gateway->value - $channel",
                    'router_id' => $mikrotik->id,
                    'type' => PlanType::PPPOE,
                ]);

                Transaction::create([
                    'invoice' => 'INV-'.Package::_raid(5),
                    'username' => $customer->username,
                    'plan_name' => $plan->name,
                    'price' => $plan->price,
                    'recharged_at' => $date_now,
                    'expired_at' => $date_exp,
                    'method' => "$gateway->value - $channel",
                    'routers' => $mikrotik->name,
                    'type' => PlanType::PPPOE,
                ]);
            }

            // $invoice = Transaction::where('username',$customer->username)->latest('id')->first();
            // TODO: send invoice
            return true;
        }
    }

    public static function changeTo(Customer $customer, Plan $plan, UserRecharge $userRecharge)
    {
        /** @var Router $mikrotik */
        $mikrotik = $userRecharge->router;
        if ($plan->router->id != $userRecharge->router_id && ! $plan->is_radius) {
            $mikrotik = $plan->router;
        }
        $client = static::resetCustomerMikrotik($mikrotik, $customer);
        if ($plan->type == PlanType::HOTSPOT) {
            if ($plan->is_radius) {
                //TODO:
            } else {
                Mikrotik::addHotspotUser($client, $plan, $customer);
            }
        } else {
            if ($plan->is_radius) {
                //TODO:
            } else {
                Mikrotik::addPpoeUser($client, $plan, $customer);
            }
        }
    }

    public static function _raid($l)
    {
        return substr(str_shuffle(str_repeat('0123456789', $l)), 0, $l);
    }

    private static function resetCustomerMikrotik(Router $mikrotik, Customer $customer)
    {
        $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
        Mikrotik::removeHotspotUser($client, $customer->username);
        Mikrotik::removePpoeUser($client, $customer->username);
        Mikrotik::removeHotspotActiveUser($client, $customer->username);
        Mikrotik::removePpoeActive($client, $customer->username);

        return $client;
    }
}
