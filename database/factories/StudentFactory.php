<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
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
        'first_name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(),
        'date_of_birth' => $this->faker->dateTimeBetween('-30 years', '-17 years')->format('Y-m-d'),
        'degree_program' => $this->faker->randomElement([
            'Ingeniería de Sistemas', 'Administración de Empresas', 'Derecho', 'Medicina', 'Psicología',
        ]),
        'registration_date' => $this->faker->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),
    ];
}
}
