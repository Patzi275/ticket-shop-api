<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'nom',
        'prix',
        'description',
        'date_limite',
        'change_prix',
        'change_date',
        'evenement_id'
    ];
}
