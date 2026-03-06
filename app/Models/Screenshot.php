<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $fillable = [
    'project_id',
    'image',
    ];

    public function projoct(){
        return $this->belongsTo(Project::class);
        }
    
}
