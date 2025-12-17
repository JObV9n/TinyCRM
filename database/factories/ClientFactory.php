<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //include all the client model fillable data with fake data
            'client_name' => $this->faker->name,
            'client_email' => $this->faker->unique()->safeEmail,
            'client_phone' => $this->faker->phoneNumber,
            'client_address' => $this->faker->address,
            'client_city' => $this->faker->city,
            'client_zipcode' => $this->faker->postcode,
           
        ];
    }
}
