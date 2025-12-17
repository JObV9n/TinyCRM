<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
        $project = Project::pluck('id');
        return [
            'title' => $this->faker->jobTitle,
            'description'=>$this->faker->paragraph,
            'deadline_at'=> $this->faker->dateTimeBetween('now','+7 month ')->format('Y-m-d'),
            'status'=>$this->faker->randomElement(TaskStatus::cases())->value,
            'user_id'=>$user->random(),
            'client_id'=>$client->random(),
            'project_id'=>$project->random(),
        ];
        
    }
}
