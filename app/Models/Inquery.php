<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];
}
