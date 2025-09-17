<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeamMember extends Model
{
    protected $fillable = [
        'member_group_id',
        'user_id',
        'designation',
        'father_name',
        'dob',
        'occuption',
        'nationality',
        'address_nepal',
        'address_china',
    ];

    public function memberGroup(): BelongsTo
    {
        return $this->BelongsTo(MemberGroup::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
