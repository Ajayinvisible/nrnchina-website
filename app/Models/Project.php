<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_keywords',
        'meta_description',
        'short_description',
        'description',
        'thumbnail',
        'date',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
