<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictionaryUser;
use App\Models\Word;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. ログインユーザーが参加している辞書IDを取得
        $dictionaryIds = DictionaryUser::where('user_id', auth()->id())
            ->pluck('dictionary_id');

        $search = collect(); // 空のコレクション

        if ($request->filled('keyword')) {
            $search = Word::whereIn('dictionary_id', $dictionaryIds)
                ->where('status', 'published')
                ->where(function($query) use ($request) {
                    $query->where('headword', 'like', '%' . $request->keyword . '%')
                        ->orWhere('reading', 'like', '%' . $request->keyword . '%');
                })
                ->get();
        }
        return view('search.index', compact('search'));

    }
}

