<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FullGallery extends Model
{
    protected $fillable = [
        'gallery_id',
        'images'
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
