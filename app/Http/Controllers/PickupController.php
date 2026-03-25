<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictionaryUser;
use App\Models\Word;


class PickupController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            // ログイン済み：自分の単語からPickUP
            $dictionaryIds = DictionaryUser::where('user_id', auth()->id())
                ->pluck('dictionary_id');
            $word = Word::whereIn('dictionary_id', $dictionaryIds)
                ->where('status', 'published')
                ->inRandomOrder()
                ->first();
        } else {
            // 未ログイン：全単語からPickUP（またはnull）
            $word = null;
        }
        return view('pickup.index', compact('word'));
    }
}
