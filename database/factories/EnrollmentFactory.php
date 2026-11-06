<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Elige un par estudiante/club que todavía no exista para respetar el
     * índice único (student_id, club_id). Si no quedan pares libres, crea
     * un estudiante y un club nuevos.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $par = DB::table('students')
            ->crossJoin('clubs')
            ->leftJoin('enrollments', function ($join) {
                $join->on('enrollments.student_id', '=', 'students.id')
                    ->on('enrollments.club_id', '=', 'clubs.id');
            })
            ->whereNull('enrollments.id')
            ->inRandomOrder()
            ->select('students.id as student_id', 'clubs.id as club_id')
            ->first();

        return [
            'student_id' => $par?->student_id ?? Student::factory(),
            'club_id' => $par?->club_id ?? Club::factory(),
            'enrollment_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'status' => $this->faker->randomElement(['pending', 'active', 'rejected', 'inactive']),
            'registered_by' => null,
        ];
    }
}
