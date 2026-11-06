<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'first_name',
    'last_name',
    'email',
    'numerodocumento',
    'date_of_birth',
    'degree_program',
    'registration_date',
    'image',
])]
#[Hidden(['password', 'remember_token'])]
class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $primaryKey = 'id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function presidedClub(): HasOne
    {
        return $this->hasOne(Club::class, 'president_id');
    }

    public function clubes(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'enrollments', 'student_id', 'club_id')
            ->withPivot(['enrollment_date', 'status'])
            ->withTimestamps();
    }
}
