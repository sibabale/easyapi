<?php
// database/factories/ProjectFactory.php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),  // Adjust as needed or use a factory for users
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'api_version' => 1,
            'api_type' => $this->faker->randomElement(['GraphQL', 'Rest']),
            'database' => 'MySQL', // Default, adjust as needed
        ];
    }
}
