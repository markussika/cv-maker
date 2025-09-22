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
        'profile_image',
        'birth_date',
        'address',
        'city',
        'country',
        'linkedin',
        'github',
        'website',
        'summary',
        'template',
        'hobbies',
        'languages',
        'work_experience',
        'education',
        'skills',
        'extra_curriculum_activities',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hobbies' => 'array',
        'languages' => 'array',
        'work_experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'extra_curriculum_activities' => 'array',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

