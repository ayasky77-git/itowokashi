<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes; //論理削除用


class Dictionary extends Model
{
    //
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'title',
        'obi_text',
        'color_code',
        'spine_pattern',
        'invite_code',
        'custom_labels',
        'creator_id',
    ];

    public function user()
    {
    return $this->belongsTo(User::class,'creator_id');
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
