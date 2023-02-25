<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'nom',
        'prenom',
        'username',
        'email',
        'password',
        'role', // client - organisateur - admin
    ];

    protected $hidden = [
        'password'
    ];
}
