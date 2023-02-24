<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    protected $fillable = [
        'somme',
        'date',
        'est_confirmer',
        'organisateur_id'
    ];
}
