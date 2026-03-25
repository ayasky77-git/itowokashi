<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class DictionaryUser extends Model
{
    protected $table = 'dictionary_user';
    protected $fillable = [
    'dictionary_id',
    'user_id',
    'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
