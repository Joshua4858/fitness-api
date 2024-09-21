<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // A role can belong to many users in a many to many relationship
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
