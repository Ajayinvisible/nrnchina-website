<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberGroup extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }
}
