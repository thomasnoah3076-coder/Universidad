<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'club_id' => Club::inRandomOrder()->first()->id,
            'enrollment_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'status' => $this->faker->randomElement(['pending', 'active', 'rejected', 'inactive']),
        ];
    }
}
