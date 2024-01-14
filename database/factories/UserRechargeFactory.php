<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRecharge>
 */
class UserRechargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id',
            'username',
            'namebp',
            'recharged_on',
            'recharged_time',
            'expiration',
            'time',
            'status',
            'method',
            'routers',
            'type',
        ];
    }
}
