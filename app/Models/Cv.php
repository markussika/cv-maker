<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'linkedin',
        'github',
        'website',
        'education',
        'experience',
        'languages',
        'skills',
        'hobbies',
        'activities',
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'languages' => 'array',
        'skills' => 'array',
        'hobbies' => 'array',
        'activities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

