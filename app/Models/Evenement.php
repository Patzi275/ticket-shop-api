<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $fillable = [
        'titre',
        'date',
        'lieu',
        'description',
        'contact',
        'organisateur_id',
        'categorie_id'
    ];
}
