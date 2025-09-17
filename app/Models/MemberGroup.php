<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberGroup extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
}
