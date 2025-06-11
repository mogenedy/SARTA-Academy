<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $institutes = \App\Models\Institute::pluck('id')->toArray();
        return [
            'title' => $this->faker->name(),
            'mission' => $this->faker->text(),
            'vision' => $this->faker->text(),
            'description' => $this->faker->text(),
            'institute_id' => fake()->randomElement($institutes),
        ];
    }
}
