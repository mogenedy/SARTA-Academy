<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institute>
 */
class InstituteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'vision' => $this->faker->text(),
            'mission' => $this->faker->text(),
            'short_name' => $this->faker->randomElement(["KFC" , "BSC" , "BCS" , "LLM" , "MMLLM" , "KFC" , "KFC" , "RNN" , "QLM"]),
            'user_id' => 1
        ];
    }
}
