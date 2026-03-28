<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;
use App\Models\Word;
use App\Models\WordReaction;

class ReactionController extends Controller
{

    public function store(Request $request,Dictionary $dictionary,Word $word)
    {
        // dd($request->all()); // ← フォームから来たデータを確認！
        
        $validated['creator_id'] = auth()->id();
        $validated['word_id'] = $word->id;
        $existing = WordReaction::where('word_id', $word->id)
            ->where('user_id', auth()->id())
            ->whereDate('reacted_on', today())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            WordReaction::create([
                'word_id' => $word->id,
                'user_id' => auth()->id(),
                'scope' => 'community',
                'reacted_on' => today(),
            ]);
        }

        if ($request->ajax()) {
            $count = WordReaction::where('word_id', $word->id)->count();
            return response()->json(['reacted' => !$existing, 'count' => $count]);
        }
        return back();

    }
}
