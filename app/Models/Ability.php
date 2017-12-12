<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $table = 'ability';

    protected $fillable = [
        'weapons', 'maps', 'user_id'
    ];
}
