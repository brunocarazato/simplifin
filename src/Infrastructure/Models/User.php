<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'cpfCnpj', 'type', 'balance', 'type'
    ];

    protected $casts = [
        'balance' => 'float',
    ];
}
