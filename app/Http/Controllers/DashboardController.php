<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DictionaryUser;
use App\Models\Word;
use App\Models\WordReaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dictCount = DictionaryUser::where('user_id', $user->id)
            ->whereHas('dictionary')
            ->count();

        $wordCount = Word::where('user_id', $user->id)
            ->whereNull('deleted_at')
            ->count();
            
        $reactionCount = WordReaction::whereIn(
            'word_id',
            Word::where('user_id', $user->id)->pluck('id')
        )->count();

        $recentWords = Word::where('user_id', $user->id)
            ->with('dictionary')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('dictCount', 'wordCount', 'reactionCount', 'recentWords'));
    }
}