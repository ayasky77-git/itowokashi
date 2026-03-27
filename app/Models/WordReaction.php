<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 👈 追加

class WordReaction extends Model
{
    protected $fillable = ['word_id', 'user_id', 'scope', 'reacted_on'];

    /**
     * このリアクションをしたユーザーを取得
     */
    public function user(): BelongsTo // 👈 追加
    {
        return $this->belongsTo(User::class);
    }

    /**
     * リアクションされた言葉を取得
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
