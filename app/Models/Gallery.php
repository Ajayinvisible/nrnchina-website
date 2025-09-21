<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_keywords',
        'meta_description',
        'thumbnail',
        'status',
    ];

    public function fullGallery() :HasOne
    {
        return $this->hasOne(FullGallery::class);
    }
}
