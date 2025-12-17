<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::pluck('id');
        $client = Client::pluck('id');
        return [
            'title' => $this->faker->jobTitle,
            'description'=>$this->faker->paragraph,
            'deadline_at'=> now()->addDays(rand(1,30))->format('Y-m-d'),
            'status'=>$this->faker->randomElement(ProjectStatus::cases())->value,
            'user_id'=>$user->random(),
            'client_id'=>$client->random(),
        ];
    }
}
