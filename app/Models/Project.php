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
      //  'screenshots',
        'problem',
        'solution',
    ];

    protected $attributes = [
    'tech_stack' => '[]'
];

    protected $casts = [
    'featured' => 'boolean',
    'tech_stack' => 'array',
   // 'screenshots' => 'array',
];


public function tags()
{
    return $this->belongsToMany(Tag::class);

}

}
