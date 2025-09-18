<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'short_description',
        'meta_description',
        'meta_keywords',
        'google_map',
    ];
}
