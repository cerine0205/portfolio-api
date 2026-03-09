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
        'demo_url',
        'presentation_url',
        'role',
        'duration',
        'type',
        'challenges',
        'results',
        'features',
        'architecture',
        'architecture_image',
        'refactor_notes',
    ];

    protected $attributes = [
    'tech_stack' => '[]',
    'features' => '[]'
];

    protected $casts = [
    'featured' => 'boolean',
    'tech_stack' => 'array',
    'features' => 'array'
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
