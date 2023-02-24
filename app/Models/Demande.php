<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'info_org',
        'info_exp',
        'user_id'
    ];
}
