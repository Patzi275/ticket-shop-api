<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = [
        'nombre',
        'date',
        'ticket_id',
        'user_id'
    ];
}
