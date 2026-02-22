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
        'tags',
        'tech_stack',
        'image',
        'screenshots',
        'problem',
        'solution',
    ];

    protected $attributes = [
    'tags' => '["test","test2"]',
    'tech_stack' => '[]',
];

    protected $casts = [
    'featured' => 'boolean',
    'tags' => 'array',
    'tech_stack' => 'array',
    'screenshots' => 'array',
];

}
