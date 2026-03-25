<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WordReaction extends Model
{
    protected $fillable = ['word_id', 'user_id', 'scope', 'reacted_on'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}

