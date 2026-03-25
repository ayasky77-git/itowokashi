<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'dictionary_id',
        'name',
        'color_code',
    ];
}
