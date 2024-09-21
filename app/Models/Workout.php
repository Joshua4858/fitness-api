<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise',
        'sets',
        'reps',
        'weight',
        'user_id',
    ];

    // A workout instance has only one user associated with it.
    // Each instance of a Workout model can belong to one instance of another model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
