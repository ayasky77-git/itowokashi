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
    'nickname',

    ];

    public function dictionary()
    {
        // 中間テーブルから Dictionary モデルへの紐付け
        return $this->belongsTo(Dictionary::class);
    }

    public function user()
    {
        // ついでに user リレーションもなければ追加しておきましょう
        return $this->belongsTo(User::class);
    }
}
