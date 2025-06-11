<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $categories = \App\Models\Category::pluck('id')->toArray();
        $institutes = \App\Models\Institute::pluck('id')->toArray();

        return [
            'title' => fake()->name(),
            'category_id' => fake()->randomElement($categories),
            'institute_id' => fake()->randomElement($institutes),
            'price' => fake()->numberBetween(100, 1000),
            'description' => fake()->text(75),
            'online' => fake()->numberBetween(0, 1),
            'live' => fake()->numberBetween(0, 1),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'duration' => fake()->randomElement(["1 month", "2 months", "3 months", "4 months", "5 months", "6 months", "7 months", "8 months", "9 months", "10 months", "11 months", "12 months"]),
            'certification' => fake()->sentence(),
            'what_will_you_learn' => [
                'description' => fake()->sentence(3),
                'points' => [
                    'first point',
                    'second point',
                    'third point',
                ],
            ],
            'level' => fake()->randomElement(["Beginner", "Intermediate", "Advanced"]),
            'curriculam' => [
                'description' => fake()->sentence(3),
                'points' => [
                    'first point',
                    'second point'
                ],
            ]
        ];
    }
}
