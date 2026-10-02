<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->sentence(),
            'foundation_date' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'president_id' => Student::inRandomOrder()->value('id'),
        ];
    }
}
