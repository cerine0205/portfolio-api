<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'content',
        'project_id',
        'is_read',
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
