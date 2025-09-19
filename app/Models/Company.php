<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function branding() :HasOne
    {
        return $this->hasOne(Branding::class);
    }

    public function contact() :HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function social(): HasMany
    {
        return $this->hasMany(Social::class);
    }
}
