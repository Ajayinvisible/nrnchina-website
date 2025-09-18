<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    protected $fillable = [
        'company_id',
        'icon',
        'number',
        'type',
        'status',
    ];

    public function company() :BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
