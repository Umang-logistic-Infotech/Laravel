<?php

namespace Database\Factories;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'studentName' => $this->faker->name(),
            'age' => $this->faker->numberBetween(10, 25),
            'percentage' => $this->faker->numberBetween(0, 100),
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'user_id' => User::factory(),
        ];
    }
}
