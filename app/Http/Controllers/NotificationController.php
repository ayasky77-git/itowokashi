<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\WordReaction;
use App\Models\Word;
use App\Models\DictionaryUser;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 自分が参加している（または作った）辞書のIDをすべて取得する
        $myDictionaryIds = DictionaryUser::where('user_id', $user->id)
            ->pluck('dictionary_id');

        // 1. 参加している辞書内でのすべての「をかし」
        $reactions = WordReaction::whereIn('word_id', function($query) use ($myDictionaryIds) {
                // 自分が参加している辞書のID一覧に属する単語のIDをすべて取得
                $query->select('id')->from('words')->whereIn('dictionary_id', $myDictionaryIds);
            })
            ->where('user_id', '!=', $user->id) // 自分のリアクションは通知しない
            ->whereHas('word.dictionary') 
            ->with(['word.dictionary', 'user'])
            ->latest()->take(20)->get()
            ->map(function($d) {
                return [
                    'type' => 'reaction',
                    'user_id' => $d->user_id,
                    'word_id' => $d->word_id,
                    'dictionary_id' => $d->word?->dictionary_id,
                    'headword' => $d->word?->headword,
                    'dictionary_title' => $d->word?->dictionary?->title,
                    'created_at' => $d->created_at,
                    'sub' => $d->word?->dictionary?->title,
                ];
            });

            // 2. 新しい言葉（修正版）
            $newWords = Word::whereIn('dictionary_id', DictionaryUser::where('user_id', $user->id)->pluck('dictionary_id'))
                ->where('user_id', '!=', $user->id)
                ->whereHas('dictionary') 
                ->with(['user', 'dictionary'])
                ->latest()->take(20)->get()
                ->map(function($d) {
                    return [
                        'type' => 'word',
                        'user_id' => $d->user_id,
                        'word_id' => $d->id, // ★ここを $d->id に修正！
                        'dictionary_id' => $d->dictionary_id,
                        'headword' => $d->headword,
                        'dictionary_title' => $d->dictionary?->title,
                        'created_at' => $d->created_at,
                        'sub' => $d->dictionary?->title,
                    ];
                });

            // 3. 辞書への参加
            $joins = DictionaryUser::whereIn('dictionary_id',
                DictionaryUser::where('user_id', $user->id)->where('role', 'admin')->pluck('dictionary_id'))
                ->where('user_id', '!=', $user->id)
                // 👇 追加：参加先の辞書が削除されていないものだけ
                ->whereHas('dictionary') 
                ->with(['user', 'dictionary'])
                ->latest()->take(20)->get()
                ->map(function($d) {
                    return [
                        'type' => 'join',
                        'user_id' => $d->user_id,
                        'word_id' => '',
                        'dictionary_id' => $d->dictionary_id,
                        'headword' => '',
                        'dictionary_title' => $d->dictionary?->title,
                        'created_at' => $d->created_at,
                        'sub' => $d->dictionary?->title,
                    ];
                });

        $notifications = $reactions->concat($newWords)->concat($joins)
            ->sortByDesc('created_at')->take(30)->values();

        return view('notifications.index', compact('notifications'));
    }
}