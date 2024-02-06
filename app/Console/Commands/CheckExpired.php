<?php

namespace App\Console\Commands;

use App\Enum\PlanType;
use App\Models\UserRecharge;
use App\Support\Mikrotik;
use Illuminate\Console\Command;

class CheckExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $services = UserRecharge::whereStatus('on')->whereDate('expired_at', '<', now())->with(['customer', 'router', 'plan'])->get();
        foreach ($services as $service) {
            /** @var UserRecharge $service */
            $client = Mikrotik::getClient($service->router->ip_address, $service->router->username, $service->router->password);
            if ($service->type == PlanType::HOTSPOT) {
                if ($service->plan->is_radius) {
                    //TODO
                } else {
                    if (! empty($service->plan->pool_expired_id)) {
                        Mikrotik::setHotspotUserPackage($client, $service->customer->username, 'EXPIRED LNUXBILL '.$service->plan->pool_expired->pool_name);
                    } else {
                        Mikrotik::removeHotspotUser($client, $service->customer->username);
                    }
                    Mikrotik::removeHotspotActiveUser($client, $service->customer->username);
                }
            } else {
                if ($service->plan->is_radius) {
                    //TODO
                } else {
                    if (! empty($service->plan->pool_expired_id)) {
                        Mikrotik::setPpoeUserPlan($client, $service->customer->username, 'EXPIRED LNUXBILL '.$service->plan->pool_expired->pool_name);
                    } else {
                        Mikrotik::removePpoeUser($client, $service->customer->username);
                    }
                    Mikrotik::removePpoeActive($client, $service->customer->username);
                }
            }
            $service->status = 'off';
            $service->save();
            $this->info("$service->expired_at : $service->username : EXPIRED");
        }
    }
}
