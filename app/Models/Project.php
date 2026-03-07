<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'year',
        'featured',
        'status',
        'team_size',
        'tech_stack',
        'image',
        'problem',
        'solution',
        'github_url',
        'live_url',
        'report_url',
        'role',
        'duration',
        'type',
        'challenges',
        'results'
    ];

    protected $attributes = [
    'tech_stack' => '[]'
];

    protected $casts = [
    'featured' => 'boolean',
    'tech_stack' => 'array',
];


public function tags()
{
    return $this->belongsToMany(Tag::class);

}

public function screenshots()
{
    return $this->hasMany(Screenshot::class);

}

public function messages()
{
    return $this->hasMany(Message::class);

}

}
