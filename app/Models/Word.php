<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dictionary;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\WordReaction;


class Word extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dictionary_id',
        'user_id',
        'headword',
        'reading',
        'initial_char',
        'raw_episode',
        'dictionary_data',
        'image_path',
        'status',
        'last_editor_id',
    ];

    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class,'dictionary_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'word_tag');
    }

    public function reactions()
    {
        return $this->hasMany(WordReaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lastEditor()
    {
        return $this->belongsTo(User::class, 'last_editor_id');
    }
    protected $casts = [
        'dictionary_data' => 'array',
    ];
}

