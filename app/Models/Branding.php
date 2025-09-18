<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branding extends Model
{
    protected $fillable = [
        'company_id',
        'logo',
        'favicon',
        'copy_right',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
