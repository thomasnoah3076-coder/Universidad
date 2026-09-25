<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['first_name', 'last_name', 'email', 'date_of_birth', 'degree_program', 'registration_date'])]
#[Hidden(['password', 'remember_token'])]
class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function presidedClub(): HasOne
    {
        return $this->hasOne(Club::class, 'president_id');
    }
}
