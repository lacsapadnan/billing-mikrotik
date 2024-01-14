<?php

namespace Database\Factories;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'pppoe_password' => $this->faker->password(),
            'fullname' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phonenumber' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'balance' => $this->faker->numberBetween(0, 1000),
            'service_type' => $this->faker->randomElement(ServiceType::cases()),
            'auto_renewal' => $this->faker->boolean(),
            'last_login' => $this->faker->dateTime(),
        ];
    }
}
