<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'nom',
        'lien',
        'taille',
        'est_principal',
        'evenement_id'
    ];
}
