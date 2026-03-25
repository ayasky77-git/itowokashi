<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;
use Illuminate\Support\Str;
use App\Models\Word;
use App\Models\DictionaryUser;
use App\Models\WordReaction;



class DictionaryController extends Controller
{
    //
    public function index()
    {
        // 🔽 追加
        $dictionaries = Dictionary::with('user')->latest()->get();
        return view('dictionaries.index', compact('dictionaries'));
    }

    public function create()
    {
        // 🔽 追加

        return view('dictionaries.create');
    }

    
    public function store(Request $request)
    {
        // dd($request->all()); // ← フォームから来たデータを確認！
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'obi_text' =>'nullable',
            'color_code' =>'nullable',
            'spine_pattern' =>'nullable',
        ]);
        $validated['creator_id'] = auth()->id();
        $validated['invite_code']=Str::random(8);
        $dictionary = Dictionary::create($validated);
        DictionaryUser::create([
            'dictionary_id' => $dictionary->id,
            'user_id' => auth()->id(),
            'role' => 'admin',
        ]);

        return redirect()->route('dictionaries.index');
    }


    public function show(Dictionary $dictionary)
    {
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }

        $words = Word::where('dictionary_id', $dictionary->id)
            ->where('status', 'published')
            ->orderBy('reading')
            ->get();

        $userRole = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->value('role');

        $members = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->with('user')
            ->get();

        $totalReactions = WordReaction::whereHas('word', fn($q) =>
            $q->where('dictionary_id', $dictionary->id)
        )->count();

        $draftCount = Word::where('dictionary_id', $dictionary->id)
            ->where('status', 'draft')
            ->count();

        return view('dictionaries.show', compact('words', 'dictionary', 'userRole', 'members', 'totalReactions','draftCount'));
    }

    public function edit(Dictionary $dictionary)
    {
        // adminのみアクセス可能
        $userRole = DictionaryUser::where('dictionary_id', $dictionary->id)
        ->where('user_id', auth()->id())
        ->value('role');

        if ($userRole !== 'admin') {
            abort(403);
        }
        $members = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->with('user')
            ->get();

        $myNickname = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->value('nickname');

        return view('dictionaries.edit', compact('dictionary', 'members', 'myNickname'));
    }

    public function update(Request $request, Dictionary $dictionary)
    {
        $validated = $request->validate([
            'title'         => 'required|max:255',
            'obi_text'      => 'nullable',
            'color_code'    => 'nullable',
            'spine_pattern' => 'nullable',
            'nickname'      => 'nullable|max:50',
        ]);

        // nicknameはdictionary_userテーブルに保存
        if (isset($validated['nickname'])) {
            DictionaryUser::where('dictionary_id', $dictionary->id)
                ->where('user_id', auth()->id())
                ->update(['nickname' => $validated['nickname']]);
            unset($validated['nickname']);
        }

        // invite_codeは再生成しない
        $dictionary->update($validated);

        return redirect()->route('dictionaries.show', $dictionary);
    }

    public function destroy(Dictionary $dictionary)
    {
        $dictionary->delete();
        return redirect()->route('dictionaries.index', [$dictionary]);    
    }

}