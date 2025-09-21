<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class President extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_keywords',
        'meta_description',
        'description',
        'image',
        'name',
        'slogan',
        'office_contact',
        'office_location',
    ];
}
