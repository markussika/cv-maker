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
        'email',
        'phone',
        'birthday',
        'country',
        'city',
        'template',
        'profile_image',
        'hobbies',
        'languages',
        'work_experience',
        'education',
        'skills',
        'extra_curriculum_activities',
    ];

    protected $casts = [
        'birthday' => 'date',
        'education' => 'array',
        'work_experience' => 'array',
        'languages' => 'array',
        'skills' => 'array',
        'hobbies' => 'array',
        'extra_curriculum_activities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

