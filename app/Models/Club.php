<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'foundation_date', 'president_id'])]
#[Hidden(['password', 'remember_token'])]
class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs';
    protected $primaryKey = 'id';

    public function president(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'president_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'club_id');
    }
}
