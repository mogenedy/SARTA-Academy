<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = \App\Models\Course::pluck('id')->toArray();

        return [
            'title' => fake()->name(),
            'description' => fake()->text(75),
            'link' => fake()->url(),
            'course_id' => fake()->randomElement($courses),    
        ];
    }
}
